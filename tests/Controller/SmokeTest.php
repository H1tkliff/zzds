<?php

namespace App\Tests\Controller;

use App\Repository\TeamRepository;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

final class SmokeTest extends WebTestCase
{
    /**
     * @dataProvider publicUrls
     */
    public function testPageLoads(string $url): void
    {
        $client = static::createClient();
        $client->request('GET', $url);

        self::assertResponseIsSuccessful();
    }

    public static function publicUrls(): iterable
    {
        yield ['/cs2'];
        yield ['/cs2/teams'];
        yield ['/login'];
        yield ['/register'];
    }

    public function testHomeRedirectsToCs2(): void
    {
        $client = static::createClient();
        $client->request('GET', '/');

        self::assertResponseRedirects('/cs2');
    }

    public function testTeamPageLoadsAndFixesWrongSlug(): void
    {
        $client = static::createClient();
        $team = static::getContainer()->get(TeamRepository::class)->findOneBy([]);
        self::assertNotNull($team, 'No teams in the test database, load the fixtures first (make test_db).');

        $url = sprintf('/cs2/team/%d-%s', $team->getId(), $team->getSlug());

        $client->request('GET', $url);
        self::assertResponseIsSuccessful();

        $client->request('GET', sprintf('/cs2/team/%d-wrong-slug', $team->getId()));
        self::assertResponseRedirects($url, 301);
    }

    public function testUnknownTeamIs404(): void
    {
        $client = static::createClient();
        $client->request('GET', '/cs2/team/999999-x');

        self::assertResponseStatusCodeSame(404);
    }
}
