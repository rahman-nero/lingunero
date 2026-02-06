# CLAUDE.md

This file provides guidance to Claude Code (claude.ai/code) when working with code in this repository.

## Project Overview

Lingunero is an English language learning web application. Users create libraries of words and sentences, practice them via flashcards and quizzes, and track statistics. An optional LLM chatbot feature exists but is currently disabled due to resource consumption.

## Tech Stack

- **Backend:** Laravel 12 (PHP 8.4) with Redis (cache/sessions) and MySQL 8.0
- **Frontend:** Vue 3 (Composition API) + Vite + Tailwind CSS 4 + Vue Router + Pinia + Axios
- **LLM Service:** FastAPI (Python 3.12) with Llama C++ (disabled in compose.yml)
- **Infrastructure:** Docker Compose (nginx, php, mysql, redis, node containers)

## Development Commands

All commands run through Docker via the Makefile in the project root:

```bash
make up                  # Start all containers
make down                # Stop containers
make build               # Rebuild containers (no cache)
make bash                # Shell into PHP container

# Backend
make migrate             # Run migrations
make migrate-seed        # Run migrations with seeders
make composer-dev-install # Install PHP dependencies
make run-tests           # Full test suite (drops DB, re-migrates, seeds, runs tests)
make tests               # Quick PHPUnit run (no DB reset)
make optimize            # Clear all Laravel caches
make laravel-cache       # Clear application cache only

# Frontend
make npm-install         # Install JS dependencies (npm ci)
make dev                 # Vite dev server with HMR
make build-production    # Production frontend build
```


Running a single test: `docker compose exec php php artisan test --filter=TestClassName`

## Architecture

### Backend (`backend/`)

Follows a layered architecture:

- **Controllers** (`app/Http/Controllers/`) - Organized by domain: `Library/`, `User/`, `LLMChat/`. Word and sentence controllers split into `ManageController` (CRUD) and `PracticeController` (practice/stats).
- **Services** (`app/Services/`) - Business logic layer. One service per domain (e.g., `WordsService`, `LibraryService`, `SentencesStatisticsService`).
- **Repositories** (`app/Repository/`) - Data access layer extending `CoreRepository`. Each entity has its own repository.
- **DTOs** (`app/DTO/`) - Data Transfer Objects passed between layers.
- **Modules** (`app/Modules/`) - Self-contained practice logic for `PracticeWords` and `PracticeSentences`. Each module has a Facade, a `ProcessorContract` interface, and processor implementations (e.g., `EnglishWords`).
- **AI** (`app/AI/`) - LLM prompt templates and provider configuration.
- **Models** (`app/Models/`) - Eloquent models: User, Words, Library, Sentences, FavoriteWord, WordExample, practice statistics, LLM chat rooms/messages.

### Frontend (`frontend/`)

Standalone Vue 3 SPA located in the `frontend/` directory with its own `package.json`:

- **Entry point:** `src/main.js` — mounts Vue with Pinia and Vue Router
- **Routing:** `src/router/index.js` — Vue Router with HTML5 history mode
- **State management:** `src/stores/` — Pinia stores
- **Views:** `src/views/` — page-level components
- **Components:** `src/components/` — reusable components
- **API calls:** `src/api/` — Axios-based API modules, one file per entity (e.g., `sentence.js`, `user.js`, `word.js`)
- **Styles:** Uses Tailwind CSS everywhere, minimal custom CSS in css-files
- **Build tool:** Vite with `@tailwindcss/vite` plugin

### Docker (`docker/`)

Dockerfiles for php (PHP 8.4-FPM), nginx (reverse proxy), node (Node 25.x for Vite), and llm (FastAPI). The LLM service is commented out in `compose.yml`.

### Deployment

GitHub Actions (`.github/workflows/deploy.yaml`) triggers on push to `main`, SSHes into the server, and runs `deploy/deploy.sh` which pulls code, rebuilds containers, installs deps, migrates, builds frontend, and clears caches.

## Testing

- PHPUnit with Laravel's testing framework
- Tests live in `backend/tests/` (Feature and Unit directories)
- `make run-tests` does a full reset: drops DB, generates app key, clears cache, migrates with seeders, then runs tests with `--env=tests`
- Test env configured in `backend/.env.testing`

## Key Conventions

- Code comments and commit messages are often in Russian
- Routes are web-based (not API-first); authenticated via Laravel Breeze session auth
- Redis is used for cache, sessions, and file storage drivers
- The LLM feature connects to the FastAPI service via `LLM_URL` env variable when enabled

## Important Rules

- **Every command MUST be run through docker-compose.** Never run commands directly on the host (e.g., use `docker compose exec node npm install axios`, not `npm install axios`).
- Never run `npm run dev` directly — use `make dev` (which runs through docker-compose).
- Use `docker compose exec node npm run build` to check for compilation errors and fix them if needed.
- Install npm packages via: `docker compose exec node npm install <package>`