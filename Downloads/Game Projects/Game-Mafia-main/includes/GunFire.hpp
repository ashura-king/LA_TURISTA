#ifndef GUNFIRE_HPP
#define GUNFIRE_HPP

#include <raylib.h>

class Gunfire
{
public:
  Gunfire(Texture2D tex, Vector2 pos, float spd, int dir);

  void Update();
  void Draw();

  bool IsActive() const { return active; }

private:
  Vector2 position;
  float speed;
  bool active;
  int direct;

  Texture2D bulletTexture;

  // Manual animation fields
  int frameCount;
  int currentFrame;
  float frameTime;
  float frameTimer;
  float frameWidth;
  float frameHeight;
  Rectangle frameRec;
};

#endif
