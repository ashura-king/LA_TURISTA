// BotSpawner.cpp
#include "includes/Bots/BotSpawner.hpp"
#include <raylib.h>
#include <algorithm>

BotSpawner::BotSpawner()
{
  encounterTimer = 0.0f;
  encounterRate = 5.0f;
  maxActiveBots = 6;
  aggressionLevel = 1.0f;
}

BotSpawner::~BotSpawner()
{
  ClearAllBots();
}

void BotSpawner::Update(float deltaTime, Vector2 playerPos)
{
  encounterTimer += deltaTime;
  CleanupDefeatedBots();

  if (encounterTimer >= encounterRate && activeBots.size() < static_cast<size_t>(maxActiveBots))
  {
    encounterTimer = 0.0f;

    float roll = GetRandomValue(0, 100) / 100.0f;
    if (roll < 0.1f)
      SpawnMixedEncounter();
    else if (roll < 0.3f)
      SpawnSquad(GetRandomValue(2, 4), GetRandomBotType());
    else
      SpawnBot(GetRandomBotType());
  }

  for (Bot *bot : activeBots)
  {
    if (bot)
    {
      bot->Update(deltaTime);
      bot->UpdateAI(playerPos, deltaTime);
    }
  }

  float baseRate = 5.0f;
  encounterRate = baseRate / (1.0f + aggressionLevel);
  if (encounterRate < 1.0f)
    encounterRate = 1.0f;
}

void BotSpawner::SpawnBot(BotType type)
{
  Vector2 pos = GetSpawnPosition();
  Bot *bot = nullptr;

  switch (type)
  {
  case BotType::STREET_THUG:
    bot = new StreetThugBot(pos.x, pos.y);
    break;
  case BotType::HEAVY:
    bot = new Heavy(pos.x, pos.y);
    break;
  case BotType::BRAWLER:
    bot = new Brawler(pos.x, pos.y);
    break;
  default:
    bot = new StreetThugBot(pos.x, pos.y);
    break;
  }

  if (bot)
  {
    bot->LoadTextures();
    activeBots.push_back(bot);
  }
}

void BotSpawner::SpawnSquad(int count, BotType type)
{
  for (int i = 0; i < count; ++i)
  {
    if (GetRandomValue(0, 100) < 30)
      SpawnBot(GetRandomBotType());
    else
      SpawnBot(type);
  }
}

void BotSpawner::SpawnMixedEncounter()
{
  int size = GetRandomValue(3, 6);
  for (int i = 0; i < size; ++i)
  {
    SpawnBot(GetRandomBotType());
  }
}

void BotSpawner::ClearAllBots()
{
  for (Bot *bot : activeBots)
  {
    delete bot;
  }
  activeBots.clear();
}

void BotSpawner::CleanupDefeatedBots()
{
  activeBots.erase(std::remove_if(activeBots.begin(), activeBots.end(), [](Bot *bot)
                                  {
        if (bot && !bot->IsAlive())
        {
            delete bot;
            return true;
        }
        return false; }),
                   activeBots.end());
}

Vector2 BotSpawner::GetSpawnPosition()
{
  Vector2 pos;
  int side = GetRandomValue(0, 3);

  switch (side)
  {
  case 0:
    pos = {-Bot::SPAWN_MARGIN, static_cast<float>(GetRandomValue(0, GetScreenHeight()))};
    break;
  case 1:
    pos = {GetScreenWidth() + Bot::SPAWN_MARGIN, static_cast<float>(GetRandomValue(0, GetScreenHeight()))};
    break;
  case 2:
    pos = {static_cast<float>(GetRandomValue(0, GetScreenWidth())), -Bot::SPAWN_MARGIN};
    break;
  case 3:
    pos = {static_cast<float>(GetRandomValue(0, GetScreenWidth())), GetScreenHeight() + Bot::SPAWN_MARGIN};
    break;
  default:
    pos = {static_cast<float>(GetScreenWidth() + Bot::SPAWN_MARGIN), static_cast<float>(GetScreenHeight() / 2)};
    break;
  }
  return pos;
}

BotType BotSpawner::GetRandomBotType()
{
  int roll = GetRandomValue(0, 100);

  if (aggressionLevel < 1.5f)
  {
    if (roll < 50)
      return BotType::STREET_THUG;
    if (roll < 70)
      return BotType::RUSHER;
    if (roll < 85)
      return BotType::THROWER;
    if (roll < 95)
      return BotType::SHOOTER;
    return BotType::BRAWLER;
  }
  else if (aggressionLevel < 3.0f)
  {
    if (roll < 30)
      return BotType::STREET_THUG;
    if (roll < 50)
      return BotType::BRAWLER;
    if (roll < 65)
      return BotType::RUSHER;
    if (roll < 80)
      return BotType::SHOOTER;
    if (roll < 90)
      return BotType::THROWER;
    return BotType::HEAVY;
  }
  else
  {
    if (roll < 20)
      return BotType::STREET_THUG;
    if (roll < 35)
      return BotType::BRAWLER;
    if (roll < 50)
      return BotType::HEAVY;
    if (roll < 65)
      return BotType::SHOOTER;
    if (roll < 80)
      return BotType::RUSHER;
    return BotType::THROWER;
  }
}

std::vector<Bot *> &BotSpawner::GetActiveBots()
{
  return activeBots;
}
