#pragma once
#include "Bot.hpp"
#include "raylib.h"

class Heavy : public Bot
{
public:
  Heavy(float spawnX, float spawnY);
  ~Heavy();

  void UpdateAI(Vector2 playerPos, float deltaTime) override;
  void LoadTextures() override;
  void Punch(Vector2 targetPos) override;

private:
  // === Heavy Mechanics ===
  float weight;
  bool isUnstoppable;
  float unstoppableTimer;

  // === Devastating Attacks ===
  float groundPoundDamage;
  float groundPoundRadius;
  bool canGroundPound;
  float groundPoundCooldown;

  // === Defensive Properties ===
  float damageReduction;
  bool immuneToKnockdown;
  float armorRating;

  // === Slow but Powerful ===
  float chargeUpTime;
  float chargeUpTimer;
  bool isChargingUp;
  float devastatingAttackMultiplier;

  // === Intimidation ===
  float intimidationRadius;
  bool causesStunNearby;
  float intimidationCooldown;

  // === Size Properties ===
  float sizeMultiplier;
  float reachBonus;
};
