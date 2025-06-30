#include "includes/Bots/Bot.hpp"
#include "raylib.h"
#include <cmath>

Bot::Bot(float spawnX, float spawnY, BotType botType)
    : x(spawnX), y(spawnY), type(botType), facing(Direction::RIGHT), health(100), maxHealth(100),
      isStunned(false), isKnockedOut(false), state(BotState::SPAWNING), stateTimer(0.0f),
      attackCooldown(0.0f), attackTimer(0.0f), stunTimer(0.0f), knockdownTimer(0.0f),
      idleTimer(0.0f), spawnTimer(2.0f), animTimer(0.0f), currentFrame(0), maxFrames(1),
      isAggressive(false), playerSpotted(false), aggroLevel(0.0f), comboCount(0), comboTimer(0.0f),
      isOnScreen(false), hasEnteredCombat(false), pacingRight(true), paceDistance(PACE_DISTANCE)
{
  speed = WALK_SPEED;
  detectionRange = DETECTION_RANGE;
  attackRange = ATTACK_RANGE;
  shootRange = SHOOT_RANGE;

  frameWidth = 64; // default size, update with texture size later
  frameHeight = 64;

  spawnPoint = {spawnX, spawnY};
  targetPosition = {spawnX, spawnY};

  InitializeByType();
  SetupPacingArea();
}

Bot::~Bot()
{
  UnloadTexture(idleTexture);
  UnloadTexture(walkTexture);
  UnloadTexture(runTexture);
  UnloadTexture(punchTexture);
  UnloadTexture(kickTexture);
  UnloadTexture(grabTexture);
  UnloadTexture(smashTexture);
  UnloadTexture(shootTexture);
  UnloadTexture(throwTexture);
  UnloadTexture(blockTexture);
  UnloadTexture(hurtTexture);
  UnloadTexture(knockdownTexture);
  UnloadTexture(deathTexture);
}

void Bot::LoadTextures() {}
void Bot::Update(float deltaTime) {}
void Bot::Draw() {}
void Bot::UpdateAI(Vector2 playerPos, float deltaTime) {}
void Bot::SpawnBehavior(float deltaTime) {}
void Bot::DirectCombatBehavior(Vector2 playerPos, float deltaTime) {}
void Bot::RangedCombatBehavior(Vector2 playerPos, float deltaTime) {}
void Bot::IdleBehavior(float deltaTime) {}

void Bot::RunTowardPlayer(Vector2 playerPos) {}
void Bot::StopAndAttack(Vector2 playerPos) {}
void Bot::PaceAround() {}
void Bot::CallForGang() {}

void Bot::Punch(Vector2 targetPos) {}
void Bot::Kick(Vector2 targetPos) {}
void Bot::Smash(Vector2 targetPos) {}
void Bot::Shoot(Vector2 targetPos) {}
void Bot::ThrowWeapon(Vector2 targetPos) {}
bool Bot::Block() { return false; }
void Bot::TakeDamage(int damage) {}
void Bot::GetKnockedDown() {}
void Bot::Die() {}

bool Bot::IsOnScreen() const { return isOnScreen; }
bool Bot::IsInAttackRange() const { return false; }
bool Bot::IsInShootRange() const { return false; }

float Bot::GetDistanceToPlayer(Vector2 playerPos) { return Vector2Distance({x, y}, playerPos); }
void Bot::ChooseDirectAttack(Vector2 playerPos) {}
void Bot::ChooseRangedAttack(Vector2 playerPos) {}

void Bot::InitializeByType() {}
void Bot::UpdateAnimation(float deltaTime) {}
void Bot::CheckScreenBounds() {}
Vector2 Bot::GetRandomSpawnPoint() { return {x, y}; }
bool Bot::CanSeePlayer(Vector2 playerPos) { return true; }
void Bot::SetStateWithTimer(BotState newState, float duration) {}

void Bot::ExecuteDirectAttack(Vector2 playerPos, float deltaTime) {}
void Bot::ExecuteRangedAttack(Vector2 playerPos, float deltaTime) {}
void Bot::ExecuteMovement(Vector2 playerPos, float deltaTime) {}
void Bot::ExecutePacing(float deltaTime) {}
void Bot::ExecuteStunned(float deltaTime) {}
void Bot::ExecuteKnockdown(float deltaTime) {}
void Bot::AttemptBlock() {}
void Bot::AttemptCounterAttack(Vector2 playerPos) {}
void Bot::SetupPacingArea() {}

void Bot::PlaySpawnSound() {}
void Bot::PlayPunchSound() {}
void Bot::PlayKickSound() {}
void Bot::PlayShootSound() {}
void Bot::PlayThrowSound() {}
void Bot::PlayHurtSound() {}
void Bot::PlayKnockdownSound() {}
void Bot::CreateHitEffect() {}
void Bot::CreateMuzzleFlash() {}
