#include "includes/GameLayer.hpp"

Gamelayer::Gamelayer(const char *file, float y, float scal)
    : yOffset(y), scale(scal), scrollX(0.0f)
{
  texture = LoadTexture(file);
}

Gamelayer::~Gamelayer()
{
  UnloadTexture(texture);
}

void Gamelayer::UpdateLayer(float playerSpeed)
{
  // Parallax effect
  scrollX -= playerSpeed * 0.5f; // Parallax factor

  // Wrap for seamless repeat
  float width = texture.width * scale;
  if (scrollX <= -width)
    scrollX += width;
  if (scrollX >= width)
    scrollX -= width;
}

void Gamelayer::Drawlayer()
{
  float width = texture.width * scale;

  // Draw repeated textures across screen width
  for (float x = scrollX; x < GetScreenWidth(); x += width)
  {
    DrawTextureEx(texture, {x, yOffset}, 0.0f, scale, WHITE);
  }

  // Draw one more before scrollX to prevent visual gap
  if (scrollX > 0)
  {
    DrawTextureEx(texture, {scrollX - width, yOffset}, 0.0f, scale, WHITE);
  }
}
