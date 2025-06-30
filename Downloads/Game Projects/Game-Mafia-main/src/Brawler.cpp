#include "includes/Bots/Brawler.hpp"

Brawler::Brawler(float spawnX, float spawnY) : Bot(spawnX, spawnY, BotType::BRAWLER)
{

  isAggressive = true;
  attackRange = ATTACK_RANGE * 1.2f;

  // Brawler properties;
  isSmashing = false;
  smashWindupTimer = 0.0f;
  smashCooldown = 3.0f;
  smashCooldownTimer = 0.0f;

  // charging
  isCharging = false;
  chargeSpeedMultiplier = 2.5f;
  chargeCooldown = 3.0f;
  chargeTimer = 0.0f;

  stunImmune = true;
  stunImmuneTimer = 2.0f;
  knockbackForce = 100.0f;
};

void Brawler::LoadTextures()
{
  // Base implementation - load placeholder textures
  // These would be overridden in specialized bot classes
  idleTexture = LoadTexture("assets/brawl/idle.png");
  walkTexture = LoadTexture("assets/brawl/walk.png");
  runTexture = LoadTexture("assets/brawl/run.png");
  smashTexture = LoadTexture("resource/brawlsmash.png");
  blockTexture = LoadTexture("assets/brawl/block.png");
  hurtTexture = LoadTexture("assets/brawl/hurt.png");
  knockdownTexture = LoadTexture("assets/brawl/knockdown.png");
  deathTexture = LoadTexture("assets/brawl/death.png");

  // Initialize animations
  idleAnim = {0, 4, 0, 0.2f, 0.0f, 0, AnimationType::REPEATING};
  walkAnim = {0, 6, 0, 0.15f, 0.0f, 0, AnimationType::REPEATING};
  runAnim = {0, 8, 0, 0.1f, 0.0f, 0, AnimationType::REPEATING};
  smashAnim = {0, 8, 0, 0.1f, 0.0f, 0, AnimationType::REPEATING};
  hurtAnim = {0, 3, 0, 0.1f, 0.0f, 0, AnimationType::ONESHOT};
  knockdownAnim = {0, 6, 0, 0.15f, 0.0f, 0, AnimationType::ONESHOT};
  deathAnim = {0, 8, 0, 0.12f, 0.0f, 0, AnimationType::ONESHOT};
};
void Brawler::UpdateAI(Vector2 playerPos, float deltaTime)
{
  Bot::UpdateAI(playerPos, deltaTime);
  smashCooldownTimer -= deltaTime;
  chargeTimer -= deltaTime;
  if (playerSpotted && GetDistanceToPlayer(playerPos) <= attackRange && CanAttack())
  {
    if (GetRandomValue(0, 100) < 60)
    {
      Smash(playerPos);
    }
  }

  // Handler
  if (isSmashing)
  {
    smashWindupTimer += deltaTime;
    if (smashWindupTimer >= smashWindup)
    {
      // TODO: Check collision & apply knockback here
      isSmashing = false;
      smashCooldownTimer = smashCooldown;
    }
  }
};
void Brawler::Smash(Vector2 targetPos)
{
  if (isSmashing || smashCooldownTimer > 0.0f)
    return;
  isSmashing = true;
  smashWindup = 0.0f;
}