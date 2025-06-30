#ifndef POPUP_HPP
#define POPUP_HPP

#include <raylib.h>
#include "Button.hpp"

class Popup
{
private:
  Vector2 position;

public:
  void DrawExitPopup(bool &running, bool &showExitPopup, Sound clickSound, Button &yesButton, Button &noButton);
};

#endif
