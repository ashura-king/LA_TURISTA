#ifndef BRAWLER_H
#define BRAWLER_H

#include "Bot.hpp"
#include "raylib.h"

class Brawler : public Bot
{
public:
  Brawler(float spawnX, float spawnY);
  ~Brawler();

  void UpdateAI(Vector2 playerPos, float deltaTime) override;
  void LoadTextures() override;
  void Smash(Vector2 targetPos);

private:
  // === Smash Mechanics ===
  bool isSmashing;
  float smashWindup;
  float smashWindupTimer;
  float smashCooldown;
  float smashCooldownTimer;

  // === Charge Attack Mechanics ===
  bool isCharging;
  float chargeCooldown;
  float chargeTimer;
  float chargeSpeedMultiplier;

  // === Defensive Traits ===
  bool stunImmune;
  float stunImmuneTimer;

  // === Offensive Force ===
  float knockbackForce;
};

#endif
