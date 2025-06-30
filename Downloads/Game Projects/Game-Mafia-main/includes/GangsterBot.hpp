#pragma once
#include "includes/Bot.hpp"

class GangsterBot : public Bot
{
public:
    GangsterBot(float startX, float startY);
    void LoadTextures() override;
    void SetProperties() override;
    BotType GetBotType() const override { return BotType::GANGSTER; }

    void UpdateAI(Vector2 playerPos, float deltaTime, const std::vector<Bot *> &allBots) override;
    void Attack() override;
    void ExecuteESWATTactics(Vector2 playerPos, float deltaTime, const std::vector<Bot *> &allBots) override;

private:
    void ExecuteGangTactics(Vector2 playerPos, float deltaTime, const std::vector<Bot *> &allBots);
    void PositionLikeGang(Vector2 playerPos, float deltaTime, const std::vector<Bot *> &allBots);
    void GangAssault(Vector2 playerPos, float deltaTime, const std::vector<Bot *> &allBots);
    void GangRetreat(Vector2 playerPos, float deltaTime, const std::vector<Bot *> &allBots);
};
