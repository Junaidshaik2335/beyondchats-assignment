# BeyondChats – Full Stack Engineer Assignment

This repository contains my submission for the BeyondChats Full Stack Engineer / Technical Product Manager assignment.

The objective of this assignment was to design and implement an end-to-end system involving backend APIs, web scraping, NodeJS automation, and a frontend interface, while making clear architectural decisions under time constraints.

---

##  Features Implemented

- Scraped BeyondChats blog articles and stored them in a database
- Built RESTful CRUD APIs using Laravel
- Implemented a NodeJS workflow to simulate:
  - Google search for related articles
  - LLM-based article enhancement
  - Publishing generated content back to backend
- Developed a ReactJS frontend to display:
  - Original articles
  - Generated (enhanced) articles with clear labels

---

##  Tech Stack

### Backend
- Laravel 12
- MySQL
- Guzzle HTTP Client
- Symfony DomCrawler

### Automation / LLM Workflow
- NodeJS
- Axios
- Simulated Google Search
- Simulated LLM-based content rewriting

### Frontend
- ReactJS (Vite)
- Axios
- Responsive UI with article cards

##  Project Structure
beyondchats-assignment/
├── laravel-backend/ # Laravel backend, scraping & APIs
├── node-llm/ # NodeJS automation & LLM workflow
├── react-frontend/ # ReactJS frontend


##  System Architecture & Data Flow

1. Laravel backend scrapes BeyondChats blog articles and stores them in MySQL.
2. CRUD APIs expose articles via `/api/articles`.
3. NodeJS script:
   - Fetches the latest article from Laravel
   - Simulates Google Search to get reference articles
   - Simulates LLM-based rewriting of content
   - Publishes the generated article back to Laravel via API
4. React frontend fetches and displays:
   - Original articles
   - Generated articles (clearly tagged)


##  Assumptions & Design Decisions

- Google Search scraping is **simulated** due to legal and technical constraints.
- LLM rewriting is **simulated** to demonstrate system flow, prompt design, and integration logic.
- Focus was placed on **architecture, data flow, reliability, and clarity** rather than perfect AI-generated content.


##  Local Setup Instructions

### Backend (Laravel)
```
cd laravel-backend
composer install
php artisan migrate
php artisan serve
```
```
Run Blog Scraper
php artisan scrape:beyondchats
```
```
NodeJS Automation (LLM Workflow)
cd node-llm
npm install
node index.js
```
```
Frontend (React)
cd react-frontend
npm install
npm run dev
```

## Local URLs
```
Backend API: `http://127.0.0.1:8000/api/articles`
```
```
Frontend UI: `http://localhost:5174`
```

## Assignment Completion Status
```
 Phase 1: Blog scraping & CRUD APIs (Laravel)

 Phase 2: NodeJS automation & LLM workflow

 Phase 3: ReactJS frontend
```
 
Thank you for reviewing my submission.