#ifndef GAME_TYPES_HPP
#define GAME_TYPES_HPP

#include <raylib.h>
#include <vector>

enum class Gamestate
{
  MENU,
  GAME,
  PLAYING
};

enum class AnimationType
{
  REPEATING,
  ONESHOT
};

enum class CharacterState
{
  ATTACKING,
  FIRING,
  JUMPING,
  RUNNING,
  WALKING,
  IDLE_RIGHT,
  IDLE_LEFT
};

enum class BotType
{
  STREET_THUG,
  SHOOTER,
  BRAWLER,
  HEAVY,
  THROWER,
  RUSHER
};
enum class BotState
{
  SPAWNING,
  IDLE,
  DIRECT_COMBAT,
  RANGED_COMBAT,
  STUNNED,
  KNOCKED_DOWN,
  DEAD
};

enum Direction
{
  LEFT = -1,
  RIGHT = 1,
  UP,
  DOWN
};

struct Animation
{
  int first;
  int last;
  int curr;
  float speed;
  float duration_left;
  int step;
  AnimationType type;
};

// Forward declarations
class Layer;
class Gamelayer;

// Function declarations
void Animation_Update(Animation *self);
Rectangle animation_frame(Animation *self, int frame_width, int frame_height);
void UpdateAndDrawLayers(const std::vector<Layer *> &layers);

#endif