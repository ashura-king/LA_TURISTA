#include "includes/Controller.hpp"
#include <raylib.h>
#include <iostream>

int main()
{
    const int screenWidth = 960;
    const int screenHeight = 540;
    const int originalWidth = 1920;
    const int originalHeight = 1080;
    InitWindow(screenWidth, screenHeight, "Mafia City");
    SetTargetFPS(60);
    Controller game;

    game.Init(screenWidth, screenHeight, originalWidth, originalHeight);

    while (!WindowShouldClose())
    {
        game.Update();
        game.Draw();
    }
    game.Unload();

    CloseAudioDevice();
    CloseWindow();
    return 0;
}