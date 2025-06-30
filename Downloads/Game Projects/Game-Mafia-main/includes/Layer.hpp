#define LAYER_H
#ifdef LAYER_H
#include <iostream>
#include <raylib.h>

class Layer
{
public:
    Layer(const char *file, float spd, float y, float scl);
    ~Layer();

    void Update();
    void Draw();

private:
    Texture2D texture;
    float scrollX;
    float speed;
    float yOffset;
    float scale;
};
#endif
