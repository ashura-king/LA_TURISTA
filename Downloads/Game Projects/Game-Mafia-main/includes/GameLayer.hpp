#ifndef GAMELAYER_HPP
#define GAMELAYER_HPP

#include <raylib.h>

class Gamelayer
{
private:
  Texture2D texture;
  float yOffset;
  float scale;
  float scrollX;

public:
  Gamelayer(const char *file, float y, float scal);
  ~Gamelayer();

  void UpdateLayer(float playerSpeed = 1.0f);
  void Drawlayer();
};

#endif
