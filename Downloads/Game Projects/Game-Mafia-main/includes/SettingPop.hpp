#include "includes/SettingMenu.hpp"
#include "includes/Button.hpp"
#include "includes/GameType.hpp"
#include <raylib.h>

class SettingPop
{
private:
  Vector2 settingPosition;

public:
  void DrawSettingPopup(bool &showSettingPopup, Sound clickSound, Button &resumeButton, Button &backToMenuButton, Gamestate &currentState);
};