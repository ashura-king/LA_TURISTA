#include "includes/Bots/Heavy.hpp"
#include <cmath>

Heavy::Heavy(float spawnX, float spawnY) : Bot(spawnX, spawnY, BotType::HEAVY)
{
  speed = WALK_SPEED * 0.6f;
  width = frameWidth * 1.5f;
  height = frameHeight * 1.5f;

  // Heavy Mechanics
  weight = 2.5f;
  isUnstoppable = false;
  unstoppableTimer = 0.0f;

  // Devastating Attacks
  groundPoundDamage = 60.0f;
  groundPoundRadius = 100.0f;
  canGroundPound = true;
  groundPoundCooldown = 8.0f;

  // Defensive Properties
  damageReduction = 0.3f; // 30% damage reduction
  immuneToKnockdown = true;
  armorRating = 0.5f;

  // Charging Attacks
  chargeUpTime = 1.5f;
  chargeUpTimer = 0.0f;
  isChargingUp = false;
  devastatingAttackMultiplier = 2.5f;

  // Intimidation
  intimidationRadius = 150.0f;
  causesStunNearby = true;
  intimidationCooldown = 5.0f;

  // Size Properties
  sizeMultiplier = 1.5f;
  reachBonus = 20.0f;
}

Heavy::~Heavy()
{
  // Cleanup
}

void Heavy::UpdateAI(Vector2 playerPos, float deltaTime)
{
  Bot::UpdateAI(playerPos, deltaTime);

  // Update timers
  if (unstoppableTimer > 0)
    unstoppableTimer -= deltaTime;
  if (chargeUpTimer > 0)
    chargeUpTimer -= deltaTime;
  if (groundPoundCooldown > 0)
    groundPoundCooldown -= deltaTime;
  if (intimidationCooldown > 0)
    intimidationCooldown -= deltaTime;

  // Heavy bots become unstoppable when low health
  if (health < maxHealth * 0.3f && !isUnstoppable)
  {
    isUnstoppable = true;
    unstoppableTimer = 5.0f;
    speed *= 1.5f; // Rage speed boost
  }

  if (unstoppableTimer <= 0)
  {
    isUnstoppable = false;
  }

  // Special ground pound attack
  if (playerSpotted && GetDistanceToPlayer(playerPos) <= attackRange &&
      canGroundPound && groundPoundCooldown <= 0)
  {
    if (GetRandomValue(0, 100) < 20) // 20% chance
    {
      isChargingUp = true;
      chargeUpTimer = chargeUpTime;
      groundPoundCooldown = 8.0f;
    }
  }

  // Execute ground pound
  if (isChargingUp && chargeUpTimer <= 0)
  {
    // Execute devastating area attack
    isChargingUp = false;
  }

  // Intimidation effect
  if (intimidationCooldown <= 0 && playerSpotted)
  {
    float distToPlayer = GetDistanceToPlayer(playerPos);
    if (distToPlayer <= intimidationRadius)
    {
      // Player gets intimidated/stunned briefly
      intimidationCooldown = 5.0f;
    }
  }
}

void Heavy::LoadTextures()
{
  Bot::LoadTextures();
  // Load heavy bot textures
}

void Heavy::Punch(Vector2 targetPos)
{
  Bot::Punch(targetPos);
  attackCooldown = 2.0f; // Slower but more powerful

  // Heavy punches have more impact
  if (GetDistanceToPlayer(targetPos) <= attackRange + reachBonus)
  {
    // Deal extra damage and knockback
  }
}
