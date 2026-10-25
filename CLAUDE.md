# CLAUDE.md

This file provides guidance to Claude Code (claude.ai/code) when working with code in this repository.

## Overview

Symfony 6.4 / PHP 8.1 app (esports site, currently CS2: teams, players, rankings), running in Docker (`php` container on PHP's built-in server at http://localhost:8080, `database` container MySQL 8.0). Docs in `README.md` and `docs/` are written in German.

**All code comments in files tracked by git must be in English** (PHP, Twig, YAML, Makefile, Dockerfile, migrations, JS/SCSS). Fixture data (team/player names) may stay in any language.

## Commands

All PHP/console commands run inside the `php` container; the `Makefile` wraps them (`make` lists targets).

- `make setup` — first-time setup: start containers, composer + npm install, build assets, rebuild DB
- `make up` / `make down` / `make build` — start / stop / rebuild containers
- `make reset_db` — drop, create, migrate, load fixtures
- `make console c=<command>` — run any `bin/console` command (e.g. `make console c=cache:clear`)
- `make composer v="<args>"` — run composer in the container (e.g. `make composer v="require symfony/mailer"`)
- `make migration_create` / `make migration_migrate` — `make:migration` / run migrations
- `make load_fixtures` — load all fixtures (fixture groups: `dev`, `live`; load one with `make console c="doctrine:fixtures:load --group=dev"`)
- `npm run dev` / `npm run watch` / `npm run build` — build frontend assets (Webpack Encore, run on the host, not in the container)
- Tests: `docker compose exec php php bin/phpunit` (single test: append the file path or `--filter testName`). `tests/` currently only has `bootstrap.php`.

There is no linter or static analyser configured.

## Architecture

- **Controllers** (`src/Controller/`, attribute routes): `/` redirects to `/cs2` (`HomeController`), which renders rankings via `RankingChangeResolver`. Team pages live in `src/Controller/Team/`. Auth: `SecurityController` (login/logout), `RegisterController`, `AccountController`.
- **Rankings are snapshots**: each `Ranking` row is a team's position/points/rating at a `snapshotDate`. `src/Service/RankingChangeResolver` compares the latest snapshot with the previous one to compute position change (`null` = new team). `RankingRepository::findBySnapshotDate()` returns rankings keyed by **team name**, which is what the change lookup matches on.
- **Entities**: `Discipline`, `Team`, `Player`, `Ranking`, `User`. Fixtures depend on each other (`DependentFixtureInterface`) in roughly Discipline → Team → Player/Ranking order.
- **Security**: entity user provider by `email`, custom `App\Security\AppAuthenticator`, remember-me enabled; `access_control` is empty.
- **Frontend**: Webpack Encore (`webpack.config.js`, entry `assets/app.js` → `public/build/`), SCSS in `assets/styles/` (Bootstrap 5), Stimulus controllers in `assets/controllers/` loaded via `@symfony/stimulus-bridge`. Encore is the only asset pipeline (AssetMapper/importmap was removed) — don't add `importmap()` calls.
- **Templates**: page layouts under `templates/page/`, discipline-specific base layout at `templates/discipline/cs/base.html.twig`, reusable partials in `templates/components/`. `mockup/zzds_rankings.html` is a static design mockup for the rankings page.
