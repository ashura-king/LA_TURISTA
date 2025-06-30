#include "includes/GameType.hpp"
#include "includes/Layer.hpp"

void Animation_Update(Animation *self)
{
  float deltaTime = GetFrameTime();
  self->duration_left -= deltaTime;

  if (self->duration_left <= 0.0f)
  {
    self->duration_left = self->speed;
    self->curr += self->step;

    if (self->curr > self->last)
    {
      switch (self->type)
      {
      case AnimationType::REPEATING:
        self->curr = self->first;
        break;
      case AnimationType::ONESHOT:
        self->curr = self->last;
        break;
      }
    }
    else if (self->curr < self->first)
    {
      switch (self->type)
      {
      case AnimationType::REPEATING:
        self->curr = self->last;
        break;
      case AnimationType::ONESHOT:
        self->curr = self->first;
        break;
      }
    }
  }
}

Rectangle animation_frame(Animation *self, int frame_width, int frame_height)
{
  int x = self->curr * frame_width;
  int y = 0;
  return Rectangle{(float)x, (float)y, (float)frame_width, (float)frame_height};
}

void UpdateAndDrawLayers(const std::vector<Layer *> &layers)
{
  for (Layer *layer : layers)
  {
    layer->Update();
    layer->Draw();
  }
}