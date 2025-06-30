#include "includes/TextOutlined.hpp"

void DrawTextOutlined(const char *text, int posX, int posY, int fontSize, Color textColor, Color outlineColor)
{
  DrawText(text, posX - 1, posY - 1, fontSize, outlineColor);
  DrawText(text, posX + 1, posY - 1, fontSize, outlineColor);
  DrawText(text, posX - 1, posY + 1, fontSize, outlineColor);
  DrawText(text, posX + 1, posY + 1, fontSize, outlineColor);
  DrawText(text, posX, posY, fontSize, textColor);
}
