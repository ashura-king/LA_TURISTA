#include "includes/Button.hpp"

Button::Button(const char *normalFile, const char *hoverFile, const char *clickFile,
               float scale, bool centered, float yOffset)
{
  normalTexture = LoadTexture(normalFile);
  hoverTexture = LoadTexture(hoverFile);
  clickTexture = LoadTexture(clickFile);

  this->scale = scale;
  isPressed = false;
  hasHoverTexture = true;
  hasClickTexture = true;

  if (centered)
  {
    position.x = (GetScreenWidth() - normalTexture.width * scale) / 2.0f;
    position.y = (GetScreenHeight() - normalTexture.height * scale) / 2.0f + yOffset;
  }
  else
  {
    position = {0, 0}; // fallback if not centered
  }
}

Button::~Button()
{
  UnloadTexture(normalTexture);
  if (hasHoverTexture)
    UnloadTexture(hoverTexture);
  if (hasClickTexture)
    UnloadTexture(clickTexture);
}

void Button::Draw()
{
  Texture2D textureToUse = normalTexture;

  if (isPressed && hasClickTexture)
    textureToUse = clickTexture;
  else if (IsHovered() && hasHoverTexture)
    textureToUse = hoverTexture;

  DrawTextureEx(textureToUse, position, 0.0f, scale, WHITE);
}

void Button::Update()
{
  if (isPressed && IsMouseButtonReleased(MOUSE_BUTTON_LEFT))
    isPressed = false;
}

bool Button::IsClicked()
{
  Vector2 mouse = GetMousePosition();
  Rectangle bounds = {
      position.x,
      position.y,
      normalTexture.width * scale,
      normalTexture.height * scale};

  if (CheckCollisionPointRec(mouse, bounds) && IsMouseButtonPressed(MOUSE_BUTTON_LEFT))
  {
    isPressed = true;
    return true;
  }

  return false;
}

bool Button::IsHovered()
{
  Vector2 mouse = GetMousePosition();
  Rectangle bounds = {
      position.x,
      position.y,
      normalTexture.width * scale,
      normalTexture.height * scale};

  return CheckCollisionPointRec(mouse, bounds);
}

Vector2 Button::GetCenteredPosition(const char *file, float scale)
{
  Texture2D temp = LoadTexture(file);
  Vector2 center = {
      (GetScreenWidth() - temp.width * scale) / 2.0f,
      (GetScreenHeight() - temp.height * scale) / 2.0f};
  UnloadTexture(temp);
  return center;
}

void Button::SetPosition(Vector2 newposition)
{
  position = newposition;
}
