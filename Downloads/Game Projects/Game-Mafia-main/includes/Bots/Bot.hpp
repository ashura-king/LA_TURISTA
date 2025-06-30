#pragma once

#include "raylib.h"
#include "raymath.h"
#include "includes/GameType.hpp"
#include <vector>

class Bot
{
public:
  Bot(float spawnX, float spawnY, BotType botType = BotType::STREET_THUG);
  virtual ~Bot();

  // Core lifecycle methods
  virtual void LoadTextures();
  virtual void Update(float deltaTime);
  virtual void Draw();

  // Direct combat AI behaviors
  virtual void UpdateAI(Vector2 playerPos, float deltaTime);
  virtual void SpawnBehavior(float deltaTime);
  virtual void DirectCombatBehavior(Vector2 playerPos, float deltaTime);
  virtual void RangedCombatBehavior(Vector2 playerPos, float deltaTime);
  virtual void IdleBehavior(float deltaTime);

  // Movement patterns
  virtual void RunTowardPlayer(Vector2 playerPos);
  virtual void StopAndAttack(Vector2 playerPos);
  virtual void PaceAround();
  virtual void CallForGang();

  // Combat actions
  virtual void Punch(Vector2 targetPos);
  virtual void Kick(Vector2 targetPos);
  virtual void Smash(Vector2 targetPos);
  virtual void Shoot(Vector2 targetPos);
  virtual void ThrowWeapon(Vector2 targetPos);
  virtual bool Block();
  virtual void TakeDamage(int damage);
  virtual void GetKnockedDown();
  virtual void Die();

  // Getters
  BotType GetBotType() const { return type; }
  BotState GetState() const { return state; }
  Vector2 GetPosition() const { return {x, y}; }
  bool IsAlive() const { return health > 0 && !isKnockedOut; }
  bool IsOnScreen() const;
  bool IsReadyToFight() const { return isOnScreen && state != BotState::SPAWNING; }
  bool CanAttack() const { return attackCooldown <= 0 && !isStunned; }
  bool IsInAttackRange() const;
  bool IsInShootRange() const;

  // Public properties
  float x, y;
  float width, height;
  int health, maxHealth;
  Direction facing;
  bool isStunned;
  bool isKnockedOut;

  // Constants
  static constexpr float SPAWN_MARGIN = 120.0f;
  static constexpr float RUN_SPEED = 120.0f;
  static constexpr float WALK_SPEED = 60.0f;
  static constexpr float DETECTION_RANGE = 300.0f;
  static constexpr float ATTACK_RANGE = 45.0f;
  static constexpr float SHOOT_RANGE = 250.0f;
  static constexpr float PACE_DISTANCE = 80.0f;

protected:
  // Identity and state
  BotType type;
  BotState state;
  float stateTimer;

  // Stats and behavior
  float speed;
  float detectionRange;
  float attackRange;
  float shootRange;
  float alertTime;
  float attackCooldown;
  float attackTimer;
  float stunTimer;
  float knockdownTimer;
  float idleTimer;
  float spawnTimer;

  // AI
  bool isAggressive;
  bool playerSpotted;
  Vector2 lastKnownPlayerPos;
  float aggroLevel;
  int comboCount;
  float comboTimer;

  // Movement
  float frameWidth, frameHeight;
  float animTimer;
  int currentFrame;
  int maxFrames;
  Vector2 spawnPoint;
  Vector2 targetPosition;
  bool isOnScreen;
  bool hasEnteredCombat;

  Vector2 paceStartPos;
  Vector2 paceEndPos;
  bool pacingRight;
  float paceDistance;

  // Combat stats
  int punchDamage;
  int kickDamage;
  int grabDamage;
  int shootDamage;
  int throwDamage;
  float blockChance;
  float counterAttackChance;

  // Textures
  Texture2D idleTexture, walkTexture, runTexture;
  Texture2D punchTexture, kickTexture, grabTexture, smashTexture;
  Texture2D shootTexture, throwTexture, blockTexture;
  Texture2D hurtTexture, knockdownTexture, deathTexture;

  // Animations
  Animation idleAnim, walkAnim, runAnim;
  Animation punchAnim, kickAnim, grabAnim, smashAnim;
  Animation shootAnim, throwAnim, blockAnim;
  Animation hurtAnim, knockdownAnim, deathAnim;

  // Helper methods
  float GetDistanceToPlayer(Vector2 playerPos);
  void ChooseDirectAttack(Vector2 playerPos);
  void ChooseRangedAttack(Vector2 playerPos);

private:
  void InitializeByType();
  void UpdateAnimation(float deltaTime);
  void CheckScreenBounds();
  Vector2 GetRandomSpawnPoint();
  bool CanSeePlayer(Vector2 playerPos);
  void SetStateWithTimer(BotState newState, float duration = 0.0f);

  void ExecuteDirectAttack(Vector2 playerPos, float deltaTime);
  void ExecuteRangedAttack(Vector2 playerPos, float deltaTime);
  void ExecuteMovement(Vector2 playerPos, float deltaTime);
  void ExecutePacing(float deltaTime);
  void ExecuteStunned(float deltaTime);
  void ExecuteKnockdown(float deltaTime);
  void AttemptBlock();
  void AttemptCounterAttack(Vector2 playerPos);
  void SetupPacingArea();

  void PlaySpawnSound();
  void PlayPunchSound();
  void PlayKickSound();
  void PlayShootSound();
  void PlayThrowSound();
  void PlayHurtSound();
  void PlayKnockdownSound();
  void CreateHitEffect();
  void CreateMuzzleFlash();
};