#ifndef CHARACTER_HPP
#define CHARACTER_HPP

#include <raylib.h>
#include "GameType.hpp"
#include "includes/GunFire.hpp"
#include <string>

class Character
{
private:
  // Textures
  Texture2D idleTexture;
  Texture2D idleLeftTexture;
  Texture2D walkTexture;
  Texture2D jumpTexture;
  Texture2D shotTexture;
  Texture2D runTexture;
  Texture2D MeleeTexture;
  Texture2D bulletTexture;
  Sound MeleeSound;
  Sound gunshotSound;
  bool soundLoaded;

  // Animations
  Animation idleRightAnim;
  Animation idleLeftAnim;
  Animation walkAnim;
  Animation jumpAnim;
  Animation shotAnim;
  Animation runAnim;
  Animation MeleeAnim;

  // Properties
  float x, y;
  float width, height;
  float speed;
  Direction direction;
  bool isWalking;
  bool isRunning;
  bool isLoaded;
  // Jump Properties
  bool isJumping;
  bool isOnGround;
  float jumpVelocity;
  float gravity;
  float groundY;
  float jumpSpeed;
  // Shot properties
  float fireTimer;
  float fireCooldown;
  bool isFiring;
  // Melee Properties
  bool isAttacking;
  float AttackTimer;
  float AttackcoolDown;
  float AttackRange;
  int AttackDamage;
  bool HitRegistered;
  float currentMovementSpeed = 0.0f;
  Vector2 position;
  int direct;
  std::vector<Gunfire> bullets;
  // Draw method
  CharacterState GetCurrentState() const;
  void GetTextureAndAnimation(Texture2D &texture, Rectangle &source);

public:
  Character(const std::string &idlePath,
            const std::string &idleLeftPath,
            const std::string &walkPath,
            const std::string &runningPath,
            const std::string &shot,
            const std::string &jump,
            const std::string &attack,
            const std::string &gunshotSoundPath,
            const std::string &attackSoundPath,
            const std::string &bulletPath,
            float startX,
            float startY,
            float characterSpeed = 2.0f);

  // Destructor
  ~Character();

  // Update methods
  void Update();
  void HandleInput();
  void UpdatePosition(float deltaX);
  void UpdateAnimations();
  void UpdateJumpAnimation();
  void UpdateShotAnimation();
  void UpdateRunAnimation();
  void UpdateAttackAnimation();
  // Movement methods
  void MoveLeft();
  void MoveRight();
  void StopMoving();
  void Jump();
  void Shot();
  void Run();
  void Attack();
  void SetPosition(float newX, float newY);
  void SetDirection(Direction newDirection);
  void PlayGunshotSound();
  void PlayAttackSound();
  void SetGunshotVolume(float volume);
  bool IsGunshotPlaying() const;
  void SetAttackSound(float volume);
  bool isAttackPlaying() const;

  Rectangle GetAttackHitbox() const;
  bool CanAttack() const;
  void ResetAttack();

  void Draw();

  float GetX() const { return x; }
  float GetY() const { return y; }
  float GetWidth() const { return width; }
  float GetHeight() const { return height; }
  Direction GetDirection() const { return direction; }
  bool IsWalking() const { return isWalking; }
  bool IsRunning() const { return isRunning; }
  bool IsJumping() const { return isJumping; }
  bool IsFiring() const { return isFiring; }
  bool IsAttacking() const { return isAttacking; }
  bool IsOnGround() const { return isOnGround; }
  bool IsLoaded() const { return isLoaded; }
  float GetAttackRange() const { return AttackRange; }
  int GetAttackDamage() const { return AttackDamage; }
  float GetCurrentMovementSpeed() const { return currentMovementSpeed; }

  // Setters
  void SetSpeed(float newSpeed) { speed = newSpeed; }
  void SetJumpSpeed(float newJumpSpeed) { jumpSpeed = newJumpSpeed; }
  void SetGravity(float newGravity) { gravity = newGravity; }
  void SetGroundY(float newGroundY) { groundY = newGroundY; }
  void SetFireCooldown(float newCooldown) { fireCooldown = newCooldown; }
  void SetAttackCooldown(float newCooldown) { AttackcoolDown = newCooldown; }
  void SetAttackRange(float newRange) { AttackRange = newRange; }
  void SetAttackDamage(int newDamage) { AttackDamage = newDamage; }
  void SetSize(float newWidth, float newHeight);
  Vector2 GetPosition() const { return position; }

  Character(const Character &) = delete;
  Character &operator=(const Character &) = delete;
};

#endif