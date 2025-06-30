// BotSpawner.hpp
#pragma once

#include "Bot.hpp"
#include "StreetThugBot.hpp"
#include "Brawler.hpp"
#include "Heavy.hpp"
#include <vector>

class BotSpawner
{
public:
  BotSpawner();
  ~BotSpawner();

  void Update(float deltaTime, Vector2 playerPos);
  void SpawnBot(BotType type);
  void SpawnSquad(int count, BotType type);
  void SpawnMixedEncounter();
  void ClearAllBots();

  std::vector<Bot *> &GetActiveBots();

private:
  std::vector<Bot *> activeBots;
  float encounterTimer;
  float encounterRate;
  int maxActiveBots;
  float aggressionLevel;

  Vector2 GetSpawnPosition();
  void CleanupDefeatedBots();
  BotType GetRandomBotType();
};
