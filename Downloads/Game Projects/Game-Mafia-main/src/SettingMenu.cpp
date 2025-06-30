#include "includes/SettingMenu.hpp"
#include <raylib.h>

SettingMenu::SettingMenu(const char *firstFile, const char *hoverFile, const char *clickFile,
                         float scale, bool useHover, bool useClick)
{
  firstTexture = LoadTexture(firstFile);
  if (useHover)
    hoverTexture = LoadTexture(hoverFile);
  if (useClick)
    clickTexture = LoadTexture(clickFile);

  this->scale = scale;
  isPressed = false;
  hasHoverTexture = useHover;
  hasClickTexture = useClick;

  float w = firstTexture.width * scale;

  // Top-right position with 10px padding
  settingPosition.x = (float)(GetScreenWidth() - w - 10);
  settingPosition.y = 10.0f;
}

SettingMenu::~SettingMenu()
{
  UnloadTexture(firstTexture);
  if (hasHoverTexture)
    UnloadTexture(hoverTexture);
  if (hasClickTexture)
    UnloadTexture(clickTexture);
}

void SettingMenu::Update()
{
  Vector2 mouse = GetMousePosition();
  Rectangle bounds = {
      settingPosition.x,
      settingPosition.y,
      firstTexture.width * scale,
      firstTexture.height * scale};

  isPressed = false;

  if (CheckCollisionPointRec(mouse, bounds))
  {
    if (IsMouseButtonPressed(MOUSE_BUTTON_LEFT))
    {
      isPressed = true;
    }
  }
}

void SettingMenu::Draw()
{
  Texture2D current = firstTexture;

  Vector2 mouse = GetMousePosition();
  Rectangle bounds = {
      settingPosition.x,
      settingPosition.y,
      firstTexture.width * scale,
      firstTexture.height * scale};

  if (CheckCollisionPointRec(mouse, bounds))
  {
    if (IsMouseButtonDown(MOUSE_BUTTON_LEFT) && hasClickTexture)
    {
      current = clickTexture;
    }
    else if (hasHoverTexture)
    {
      current = hoverTexture;
    }
  }

  DrawTextureEx(current, settingPosition, 0.0f, scale, WHITE);
}

bool SettingMenu::WasClicked() const
{
  return isPressed;
}
