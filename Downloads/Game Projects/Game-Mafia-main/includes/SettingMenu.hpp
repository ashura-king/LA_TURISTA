#ifndef SETTING_HPP
#define SETTING_HPP

#include "raylib.h"

class SettingMenu
{
private:
  Texture2D firstTexture;
  Texture2D hoverTexture;
  Texture2D clickTexture;
  Vector2 settingPosition;
  float scale;
  bool isPressed;
  bool hasHoverTexture;
  bool hasClickTexture;

public:
  SettingMenu(const char *firstFile, const char *hoverFile, const char *clickFile,
              float scale, bool useHover, bool useClick);

  ~SettingMenu();

  void Update();
  void Draw();
  bool WasClicked() const;
};

#endif // SETTING_HPP
