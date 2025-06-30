#include "includes/Character.hpp"
#include "includes/GunFire.hpp"
#include <raylib.h>
#include <algorithm>

Character::Character(const std::string &idlePath,
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
                     float characterSpeed)
    : idleTexture{},
      idleLeftTexture{},
      walkTexture{},
      jumpTexture{},
      shotTexture{},
      runTexture{},
      MeleeTexture{},
      bulletTexture{},
      MeleeSound{},
      gunshotSound{},
      soundLoaded(false),
      idleRightAnim{},
      idleLeftAnim{},
      walkAnim{},
      jumpAnim{},
      shotAnim{},
      runAnim{},
      MeleeAnim{},
      x(startX),
      y(startY),
      width(0),
      height(0),
      speed(characterSpeed),
      direction(RIGHT),
      isWalking(false),
      isRunning(false),
      isLoaded(true),
      isJumping(false),
      isOnGround(true),
      jumpVelocity(0.0f),
      gravity(0.8f),
      groundY(startY),
      jumpSpeed(15.0f),
      fireTimer(0.0f),
      fireCooldown(0.3f),
      isFiring(false),
      isAttacking(false),
      AttackTimer(0.0f),
      AttackcoolDown(0.5f),
      AttackRange(50.0f),
      AttackDamage(25),
      HitRegistered(false)
{

  groundY = startY;

  idleTexture = LoadTexture(idlePath.c_str());
  idleLeftTexture = LoadTexture(idleLeftPath.c_str());
  walkTexture = LoadTexture(walkPath.c_str());

  if (idleTexture.id == 0)
  {
    TraceLog(LOG_ERROR, "Failed to load idle texture: %s", idlePath.c_str());
    isLoaded = false;
  }
  if (idleLeftTexture.id == 0)
  {
    TraceLog(LOG_ERROR, "Failed to load idle left texture: %s", idleLeftPath.c_str());
    isLoaded = false;
  }
  if (walkTexture.id == 0)
  {
    TraceLog(LOG_ERROR, "Failed to load walk texture: %s", walkPath.c_str());
    isLoaded = false;
  }

  if (!attack.empty())
  {
    MeleeTexture = LoadTexture(attack.c_str());
    if (MeleeTexture.id == 0)
    {
      TraceLog(LOG_ERROR, "Failed to load melee texture: %s", attack.c_str());
    }
  }
  else
  {
    MeleeTexture = {0};
  }

  if (!runningPath.empty())
  {
    runTexture = LoadTexture(runningPath.c_str());
    if (runTexture.id == 0)
    {
      TraceLog(LOG_ERROR, "Failed to load running texture: %s", runningPath.c_str());
      runTexture = {0};
    }
  }
  else
  {
    runTexture = {0};
  }

  if (!shot.empty())
  {
    shotTexture = LoadTexture(shot.c_str());
    if (shotTexture.id == 0)
    {
      TraceLog(LOG_ERROR, "Failed to load shot texture: %s", shot.c_str());
    }
  }
  else
  {
    shotTexture = {0};
  }

  if (!jump.empty())
  {
    jumpTexture = LoadTexture(jump.c_str());
    if (jumpTexture.id == 0)
    {
      TraceLog(LOG_ERROR, "Failed to load jump texture: %s", jump.c_str());
    }
  }
  else
  {
    jumpTexture = {0};
  }

  if (!bulletPath.empty())
  {
    bulletTexture = LoadTexture(bulletPath.c_str());
    if (bulletTexture.id == 0)
    {
      TraceLog(LOG_ERROR, "failed to load bullet texture %s", bulletPath.c_str());
    }
  }
  else
  {
    bulletTexture = {0};
  }

  if (!gunshotSoundPath.empty())
  {
    gunshotSound = LoadSound(gunshotSoundPath.c_str());

    if (gunshotSound.stream.buffer != nullptr)
    {
      soundLoaded = true;
      SetSoundVolume(gunshotSound, 0.7f);
    }
    else
    {
      TraceLog(LOG_ERROR, "Failed to load gunshot sound: %s", gunshotSoundPath.c_str());
      soundLoaded = false;
    }
  }

  if (!attackSoundPath.empty())
  {
    MeleeSound = LoadSound(attackSoundPath.c_str());

    if (MeleeSound.stream.buffer != nullptr)
    {
      soundLoaded = true;
      SetSoundVolume(MeleeSound, 0.7f);
    }
    else
    {
      TraceLog(LOG_ERROR, "Failed to load gunshot sound: %s", attackSoundPath.c_str());
      soundLoaded = false;
    }
  }

  // Set character dimensions
  width = 128 * 2;
  height = 128 * 2;

  // Initialize animations
  idleRightAnim = {0, 4, 0, 0.15f, 0.15f, 1, AnimationType::REPEATING};
  idleLeftAnim = {0, 4, 0, 0.15f, 0.15f, 1, AnimationType::REPEATING};
  walkAnim = {0, 5, 0, 0.08f, 0.08f, 1, AnimationType::REPEATING};
  jumpAnim = {0, 9, 0, 0.1f, 0.1f, 1, AnimationType::ONESHOT};
  shotAnim = {0, 4, 0, 0.05f, 0.05f, 1, AnimationType::ONESHOT};
  runAnim = {0, 9, 0, 0.1f, 0.1f, 1, AnimationType::REPEATING};
  MeleeAnim = {0, 3, 0, 0.1f, 0.1f, 1, AnimationType::ONESHOT};
};

Character::~Character()
{
  // Unload textures
  if (idleTexture.id != 0)
    UnloadTexture(idleTexture);
  if (idleLeftTexture.id != 0)
    UnloadTexture(idleLeftTexture);
  if (walkTexture.id != 0)
    UnloadTexture(walkTexture);
  if (jumpTexture.id != 0)
    UnloadTexture(jumpTexture);
  if (shotTexture.id != 0)
    UnloadTexture(shotTexture);
  if (runTexture.id != 0)
    UnloadTexture(runTexture);
  if (MeleeTexture.id != 0)
    UnloadTexture(MeleeTexture);
  if (bulletTexture.id != 0)
    UnloadTexture(bulletTexture);

  // Unload sound resource
  if (soundLoaded)
  {
    UnloadSound(gunshotSound);
    UnloadSound(MeleeSound);
  }
}

void Character::Update()
{
  fireTimer -= GetFrameTime();
  fireTimer = std::max(fireTimer, 0.0f);

    float screenWidth = GetScreenWidth();
  if (x < 0)
    x = 0;
  if (x + width > screenWidth)
    x = screenWidth - width;

  for (auto &bullet : bullets)
  {
    bullet.Update();
  }

  UpdateAnimations();
  UpdateJumpAnimation();
  UpdateShotAnimation();
  UpdateRunAnimation();
  UpdateAttackAnimation();
}

void Character::HandleInput()
{
  bool wasMoving = false;

  if (IsKeyDown(KEY_D) || IsKeyDown(KEY_RIGHT))
  {
    if (IsKeyDown(KEY_SPACE))
    {
      direction = RIGHT;
      Run();
    }
    else
    {
      MoveRight();
    }
    wasMoving = true;
  }
  else if (IsKeyDown(KEY_A) || IsKeyDown(KEY_LEFT))
  {
    if (IsKeyDown(KEY_SPACE))
    {
      direction = LEFT;
      Run();
    }
    else
    {
      MoveLeft();
    }
    wasMoving = true;
  }

  if (!wasMoving)
  {
    StopMoving();
  }

  if (IsKeyDown(KEY_W) || IsKeyDown(KEY_UP))
  {
    Jump();
  }

  if ((IsKeyDown(KEY_J) || IsMouseButtonPressed(MOUSE_BUTTON_LEFT)) && fireTimer <= 0.0f)
  {
    Shot();
  }

  if ((IsKeyDown(KEY_K) || IsMouseButtonPressed(MOUSE_BUTTON_RIGHT)) && AttackTimer <= 0.0f)
  {
    Attack();
  }
}

void Character::UpdatePosition(float deltaX)
{
  x += deltaX;
  if (deltaX != 0)
  {
    isWalking = true;
    direction = (deltaX > 0) ? RIGHT : LEFT;
  }
  else
  {
    isWalking = false;
  }
}

void Character::UpdateAnimations()
{
  if (isAttacking)
  {
    Animation_Update(&MeleeAnim);
  }
  if (isFiring)
  {
    Animation_Update(&shotAnim);
  }
  else if (isJumping)
  {
    Animation_Update(&jumpAnim);
  }
  else if (isRunning)
  {
    Animation_Update(&runAnim);
  }
  else if (isWalking)
  {
    Animation_Update(&walkAnim);
  }
  else
  {
    if (direction == RIGHT)
    {
      Animation_Update(&idleRightAnim);
    }
    else
    {
      Animation_Update(&idleLeftAnim);
    }
  }
}

void Character::UpdateJumpAnimation()
{
  if (isJumping)
  {
    jumpVelocity += gravity;
    y += jumpVelocity;

    if (y >= groundY)
    {
      y = groundY;
      isJumping = false;
      isOnGround = true;
      jumpVelocity = 0.0f;
    }
  }
}

void Character::UpdateRunAnimation()
{
  if (isRunning)
  {
    Animation_Update(&runAnim);
  }
}

void Character::UpdateShotAnimation()
{
  if (isFiring)
  {
    fireTimer -= GetFrameTime();
    if (fireTimer <= 0.0f)
    {
      isFiring = false;
      shotAnim.curr = shotAnim.first;
      shotAnim.duration_left = shotAnim.speed;
      TraceLog(LOG_INFO, "Attack movement applied:");
    }
  }
}

void Character::UpdateAttackAnimation()
{
  static bool attackMoveApplied = false;

  if (isAttacking)
  {

    if (AttackTimer == AttackcoolDown)
    {
      attackMoveApplied = false;
    }

    AttackTimer -= GetFrameTime();

    if (!attackMoveApplied && AttackTimer <= (AttackcoolDown * 0.6f))
    {
      float moveDistance = AttackRange * 0.4f;
      if (direction == RIGHT)
      {
        x += moveDistance;
      }
      else
      {
        x -= moveDistance;
      }
      attackMoveApplied = true;
      TraceLog(LOG_INFO, "Attack movement applied: %.2f", moveDistance);
    }

    if (AttackTimer <= 0.0f)
    {
      isAttacking = false;
      MeleeAnim.curr = MeleeAnim.first;
      MeleeAnim.duration_left = MeleeAnim.speed;
      attackMoveApplied = false;
    }
  }
}

void Character::MoveLeft()
{
  x -= speed;
  direction = LEFT;
  isWalking = true;
  isRunning = false;
  currentMovementSpeed = -speed;
}

void Character::MoveRight()
{
  x += speed;
  direction = RIGHT;
  isWalking = true;
  isRunning = false;
  currentMovementSpeed = speed;
}

void Character::StopMoving()
{
  isWalking = false;
  isRunning = false;
  currentMovementSpeed = 0.0f;
}

void Character::Jump()
{
  if (isOnGround)
  {
    isJumping = true;
    isOnGround = false;
    jumpVelocity = -jumpSpeed;

    jumpAnim.curr = jumpAnim.first;
    jumpAnim.duration_left = jumpAnim.speed;
  }
}

void Character::Run()
{
  float runSpeed = speed * 2.0f;
  if (direction == RIGHT)
  {
    x += runSpeed;
  }
  else
  {
    x -= runSpeed;
  }

  isRunning = true;
  isWalking = false;
}

void Character::Shot()
{
  if (!isFiring)
  {
    isFiring = true;
    fireTimer = fireCooldown;
    shotAnim.curr = shotAnim.first;
    shotAnim.duration_left = shotAnim.speed;

    if (soundLoaded)
      PlaySound(gunshotSound);

    float muzzleOffsetX = (direction == Direction::RIGHT) ? (width - 9.0f) : (9.0f);
    float muzzleOffsetY = height / 1.5f;
    Vector2 pos = {
        x + muzzleOffsetX,
        y + muzzleOffsetY};

    int dir = (direction == Direction::RIGHT) ? 1 : -1;
    float spd = 8.0f;

    // Optional: check texture
    if (bulletTexture.id == 0)
    {
      TraceLog(LOG_WARNING, "Bullet texture not loaded!");
    }

    Gunfire bullet(bulletTexture, pos, spd, dir);
    bullets.push_back(bullet);
  }
}

void Character::Attack()
{
  if (!isAttacking && AttackTimer <= 0.0f)
  {
    isAttacking = true;
    AttackTimer = AttackcoolDown;
    MeleeAnim.curr = MeleeAnim.first;
    MeleeAnim.duration_left = MeleeAnim.speed;
    PlayAttackSound();

    TraceLog(LOG_INFO, "Attack triggered with forward movement.");
  }
}

bool Character::CanAttack() const
{
  return !isAttacking && AttackTimer <= 0.0f;
}

void Character::ResetAttack()
{
  isAttacking = false;
  AttackTimer = 0.0f;
  HitRegistered = false;
  MeleeAnim.curr = 0;
}

void Character::PlayGunshotSound()
{
  if (soundLoaded)
  {
    if (IsSoundPlaying(gunshotSound))
    {
      StopSound(gunshotSound);
    }
    PlaySound(gunshotSound);
  }
}

void Character::PlayAttackSound()
{

  if (soundLoaded)
  {

    float originalVolume = 0.7f;
    SetSoundVolume(MeleeSound, 0.4f);

    if (IsSoundPlaying(MeleeSound))
    {
      StopSound(MeleeSound);
    }
    PlaySound(MeleeSound);

    SetSoundVolume(MeleeSound, originalVolume);
  }
}

bool Character::IsGunshotPlaying() const
{
  if (soundLoaded)
  {
    return IsSoundPlaying(gunshotSound);
  }
  return false;
}

void Character::SetGunshotVolume(float volume)
{
  if (soundLoaded)
  {
    SetSoundVolume(gunshotSound, std::clamp(volume, 0.0f, 1.0f));
  }
}

void Character::SetPosition(float newX, float newY)
{
  x = newX;
  y = newY;
}

void Character::SetDirection(Direction newDirection)
{
  direction = newDirection;
}

void Character::SetSize(float newWidth, float newHeight)
{
  width = newWidth;
  height = newHeight;
}

CharacterState Character::GetCurrentState() const
{
  if (isAttacking && MeleeTexture.id != 0)
    return CharacterState::ATTACKING;
  if (isFiring && shotTexture.id != 0)
    return CharacterState::FIRING;

  if (isJumping && jumpTexture.id != 0)
    return CharacterState::JUMPING;

  if (isRunning && runTexture.id != 0)
    return CharacterState::RUNNING;

  if (isWalking)
    return CharacterState::WALKING;

  return (direction == RIGHT) ? CharacterState::IDLE_RIGHT : CharacterState::IDLE_LEFT;
}

void Character::GetTextureAndAnimation(Texture2D &texture, Rectangle &source)
{
  CharacterState state = GetCurrentState();

  switch (state)
  {
  case CharacterState::ATTACKING:
    texture = MeleeTexture;
    source = animation_frame(&MeleeAnim, 128, 128);
    if (direction == LEFT)
      source.width = -source.width;
    break;
  case CharacterState::FIRING:
    texture = shotTexture;
    source = animation_frame(&shotAnim, 128, 128);
    if (direction == LEFT)
      source.width = -source.width;
    break;

  case CharacterState::JUMPING:
    texture = jumpTexture;
    source = animation_frame(&jumpAnim, 128, 128);
    source.width = (direction == LEFT) ? -128 : 128;
    break;

  case CharacterState::RUNNING:
    texture = runTexture;
    source = animation_frame(&runAnim, 128, 128);
    source.width = (direction == LEFT) ? -128 : 128;
    break;

  case CharacterState::WALKING:
    texture = walkTexture;
    source = animation_frame(&walkAnim, 128, 128);
    if (direction == LEFT)
      source.width = -source.width;
    break;

  case CharacterState::IDLE_RIGHT:
    texture = idleTexture;
    source = animation_frame(&idleRightAnim, 128, 128);
    break;

  case CharacterState::IDLE_LEFT:
    texture = idleLeftTexture;
    source = animation_frame(&idleLeftAnim, 128, 128);
    break;

  default:
    // Fallback to idle right
    texture = idleTexture;
    source = animation_frame(&idleRightAnim, 128, 128);
    break;
  }
}

void Character::Draw()
{
  if (!isLoaded)
    return;

  Texture2D currentTexture;
  Rectangle source;

  GetTextureAndAnimation(currentTexture, source);

  Rectangle dest = {x, y, width, height};
  Vector2 origin = {0, 0};

  DrawTexturePro(currentTexture, source, dest, origin, 0.0f, WHITE);
  for (auto &bullet : bullets)
  {
    bullet.Draw();
  }
}