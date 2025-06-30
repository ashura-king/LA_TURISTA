#include "includes/Popup.hpp"
#include "includes/Button.hpp"

void Popup::DrawExitPopup(bool &running, bool &showExitPopup, Sound clickSound, Button &yesButton, Button &noButton)
{
  // Dim background
  DrawRectangle(0, 0, GetScreenWidth(), GetScreenHeight(), Fade(BLACK, 0.5f));

  // Popup box dimensions and position
  int boxWidth = 350;
  int boxHeight = 160;
  int boxX = GetScreenWidth() / 2 - boxWidth / 2;
  int boxY = GetScreenHeight() / 2 - boxHeight / 2;

  // Popup background
  DrawRectangle(boxX, boxY, boxWidth, boxHeight, DARKGRAY);

  // Optional: border for better contrast
  DrawRectangleLines(boxX, boxY, boxWidth, boxHeight, RAYWHITE);

  // Centered message
  const char *message = "Do you want to exit?";
  int textWidth = MeasureText(message, 20);
  DrawText(message, boxX + (boxWidth - textWidth) / 2, boxY + 20, 20, RAYWHITE);

  // Position buttons
  yesButton.SetPosition({(float)(boxX + 40), (float)(boxY + 90)});
  noButton.SetPosition({(float)(boxX + 180), (float)(boxY + 90)});

  yesButton.Update();
  noButton.Update();
  // Draw buttons
  yesButton.Draw();
  noButton.Draw();

  // Handle click (assumes IsClicked uses IsMouseButtonPressed internally)
  if (yesButton.IsClicked())
  {
    PlaySound(clickSound);
    running = false;
  }
  else if (noButton.IsClicked())
  {
    PlaySound(clickSound);
    showExitPopup = false;
  }

  if (IsKeyPressed(KEY_ESCAPE))
  {
    showExitPopup = false;
  }
}
