#ifndef BUTTON_H
#define BUTTON_H

#include "raylib.h"

class Button
{
private:
  Texture2D normalTexture;
  Texture2D hoverTexture;
  Texture2D clickTexture;
  Vector2 position;
  float scale;
  bool isPressed;
  bool hasHoverTexture;
  bool hasClickTexture;

public:
  // Constructor for centered button with all effects (your current use case)
  Button(const char *normalFile, const char *hoverFile, const char *clickFile,
         float scale, bool centered = true, float yOffset = 0.0f);

  ~Button();

  void Draw();
  void Update();
  bool IsClicked();
  bool IsHovered();
  void SetPosition(Vector2 newposition);

  static Vector2 GetCenteredPosition(const char *file, float scale);
};

#endif
