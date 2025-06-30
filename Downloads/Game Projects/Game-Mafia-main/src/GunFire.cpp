#include "includes/GunFire.hpp"
#include <raylib.h>

Gunfire::Gunfire(Texture2D tex, Vector2 pos, float spd, int dir)
    : position(pos),
      speed(spd),
      active(true),
      direct(dir),
      bulletTexture(tex),
      frameCount(3),
      currentFrame(0),
      frameTime(0.1f),
      frameTimer(0.0f),
      frameWidth(static_cast<float>(tex.width) / 3),
      frameHeight(static_cast<float>(tex.height)),
      frameRec{0.0f, 0.0f, frameWidth, frameHeight}
{

  // Use float for precise frame width if image width isn't divisible by frameCount
  float frameWidth = static_cast<float>(tex.width) / frameCount;
  float frameHeight = static_cast<float>(tex.height);

  frameRec = {0.0f, 0.0f, frameWidth, frameHeight};
}

void Gunfire::Update()
{
  // Move the bullet
  position.x += speed * direct;

  // Animate the bullet
  frameTimer += GetFrameTime();
  if (frameTimer >= frameTime)
  {
    frameTimer = 0.0f;
    currentFrame = (currentFrame + 1) % frameCount;
    frameRec.x = currentFrame * frameWidth;
  }

  // Deactivate if offscreen
  if (position.x < -frameWidth || position.x > GetScreenWidth() + frameWidth)
    active = false;
}

void Gunfire::Draw()
{
  if (!active)
    return;

  Rectangle drawFrame = frameRec;

  if (direct == -1)
  {
    // Flip horizontally
    drawFrame.width = -frameRec.width;
    drawFrame.x += frameRec.width; // Adjust origin so it doesn't flip offset
  }

  DrawTextureRec(bulletTexture, drawFrame, position, RAYWHITE);
}
