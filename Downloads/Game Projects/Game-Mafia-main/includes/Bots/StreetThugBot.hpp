#ifndef STREETTHUGBOT_H
#define STREETTHUGBOT_H
#include "Bot.hpp"
#include "raylib.h"

class StreetThugBot : public Bot
{
public:
  StreetThugBot(float spawnX, float spawnY);
  ~StreetThugBot();

  void UpdateAI(Vector2 playerPos, float deltaTime) override;
  void LoadTextures() override;

private:
  // === Street Fighting Mechanics ===

  // === Pack Behavior ===
  bool callsForBackup;
  float backupCallCooldown;
  float backupCallTimer;

  // === Aggressive Traits ===
  float aggressionBoost;
  bool alwaysAdvances;
  float retreatThreshold;

  // === Quick Combat ===
  float comboChance;
  bool canDoCombo;
  int maxComboHits;
};
#endif
