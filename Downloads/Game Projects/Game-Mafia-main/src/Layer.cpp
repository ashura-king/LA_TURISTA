#include "includes/Layer.hpp"

Layer::Layer(const char *file, float spd, float y, float scl)
    : scrollX(0), speed(spd), yOffset(y), scale(scl)
{
  texture = LoadTexture(file);
}

Layer::~Layer() { UnloadTexture(texture); }
void Layer::Update()
{
  scrollX -= speed;
  float width = texture.width * scale;
  if (scrollX <= -width)
    scrollX += width;
}

void Layer::Draw()
{
  float width = texture.width * scale;
  DrawTextureEx(texture, {scrollX, yOffset * scale}, 0.0f, scale, WHITE);
  DrawTextureEx(texture, {scrollX + width, yOffset * scale}, 0.0f, scale, WHITE);
}
