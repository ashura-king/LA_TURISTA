#include "includes/SettingMenu.hpp"
#include "includes/Button.hpp"
#include "includes/GameType.hpp"
#include "includes/SettingPop.hpp"
#include <raylib.h>

void SettingPop::DrawSettingPopup(bool &showSettingPopup, Sound clickSound, Button &resumeButton, Button &backToMenuButton, Gamestate &currentState)
{

  DrawRectangle(0, 0, GetScreenWidth(), GetScreenHeight(), Fade(BLACK, 0.5f));

  int boxWidth = 400;
  int boxHeight = 200;
  int boxX = GetScreenWidth() / 2 - boxWidth / 2;
  int boxY = GetScreenHeight() / 2 - boxHeight / 2;

  DrawRectangle(boxX, boxY, boxWidth, boxHeight, DARKGRAY);
  DrawRectangleLines(boxX, boxY, boxWidth, boxHeight, RAYWHITE);

  // Title
  const char *title = "Settings";
  int tiltleWidth = MeasureText(title, 20);
  DrawText(title, boxX + (boxWidth - tiltleWidth) / 2, boxY + 20, 20, RAYWHITE);

  // Buttons
  resumeButton.SetPosition({(float)(boxX + 40), (float)(boxY + 100)});
  backToMenuButton.SetPosition({(float)(boxX + 200), (float)(boxY + 100)});

  resumeButton.Update();
  backToMenuButton.Update();

  resumeButton.Draw();
  backToMenuButton.Draw();

  if (resumeButton.IsClicked())
  {
    PlaySound(clickSound);
    showSettingPopup = false;
  }
  else if (backToMenuButton.IsClicked())
  {
    PlaySound(clickSound);
    showSettingPopup = false;
    currentState = Gamestate::MENU;
  }

  if (IsKeyPressed(KEY_ESCAPE))
  {
    showSettingPopup = false;
  }
}
