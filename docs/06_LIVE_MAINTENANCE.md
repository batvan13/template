# LIVE MAINTENANCE WORKFLOW

## 1. PURPOSE

Оперативен ред за промени по **live** клиентски проекти: ясен вход, малки стъпки, контрол на риска и deploy без изненади.

## 2. CHANGE REQUEST

Всяка работа започва с **change request**. Минимален шаблон:

- **client** — кой клиент / кой проект  
- **request** — какво искат (факти)  
- **type** — `bug` / `improvement` / `integration` / `feature`  
- **impact** — кои страници или потоци се пипат  
- **risk level** — ниска / средна / висока (субективно, но записано)

**Правило:** без request → няма работа.

## 3. WORKFLOW PIPELINE

1. **request** — фиксиран вход с type и risk.  
2. **analysis** — уточняване на scope, зависимости, дали пипаме DB/API.  
3. **task** — структурирана задача по `docs/02_TASK_TEMPLATE.md`.  
4. **implementation (Cursor)** — код по задачата, минимален diff.  
5. **review** — преглед спрямо задачата и контекста на проекта.  
6. **testing** — локално / staging според типа промяна.  
7. **commit** — ясно съобщение, една логическа промяна.  
8. **deploy** — по установения за проекта начин (ръчно или скрипт).  
9. **smoke test** — бърза проверка на критичните потоци след deploy.

## 4. CHANGE TYPES

### LOW

- **Включва:** текст, стил, малки UI корекции без логика, конфиг без промяна на поведение.  
- **Процес:** request → кратка задача → имплементация → лек тест → deploy.

### MEDIUM

- **Включва:** бъгове в съществуваща логика, малки feature-и, промени в Blade/контролер без нова архитектура.  
- **Процес:** пълен pipeline до review; тест на засегнатите потоци преди deploy.

### HIGH

- **Включва:** DB миграции, auth, плащания, поща, bulk данни, промени с широк side effect.  
- **Процес:** по-строг analysis, backup преди deploy, smoke + регресия на home/admin/засегнат feature.

## 5. DEPLOYMENT RULES

**Before deploy**

- backup на DB (или потвърден план за възстановяване)  
- проверка на **env** (ключове, `APP_DEBUG`, mail)  
- миграции: ясно кои се пускат и в какъв ред  

**After deploy**

- тест на **начална страница**  
- тест на **admin** (логин + основен модул)  
- тест на **променения feature**  
- тест на **един съществуващ поток**, който не трябва да е счупен  

## 6. HOTFIX MODE

**Hotfix** — спешна корекция на production (security, downtime, критичен бъг).

**Правила:**

- **минимална** промяна — само фиксът, без „докато сме тук“.  
- **бърз тест** — поне happy path на проблема.  
- **веднага deploy** — след проверка на checklist за env/миграции ако има.  
- **след това** — кратък smoke на сайта и admin; при нужда допълване на request/task постфактум.

## 7. FORBIDDEN ACTIONS

- Няма директни редакции по production сървър (FTP/SSH edit на live код).  
- Няма промени без одобрен task.  
- Няма deploy без минимален тест.  
- Няма архитектурни промени без изрично одобрение.

## 8. RESPONSIBILITIES

| Роля | Отговорност |
|------|----------------|
| **Architect (user)** | Scope, одобрение на рискови промени, deploy decision, клиентска комуникация. |
| **Analyst (ChatGPT)** | Разбиване на request, уточнения, чернова на task, проверка срещу docs. |
| **Executor (Cursor)** | Имплементация по task, минимален diff, отчет след работа. |

## 9. ROLLBACK RULE

If a deploy causes issues:

- revert to previous working version (git rollback or backup restore)
- stop further changes
- identify root cause before re-deploy

Rule:
No “quick fixes” on broken production.
Always stabilize first, then fix properly.
