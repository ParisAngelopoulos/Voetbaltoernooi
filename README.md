<p align="center">
  <img src=".github/banner.svg" alt="Voetbaltoernooi – teams, wedstrijden en uitslagen" width="100%">
</p>

<p align="center">
  <img src="https://img.shields.io/badge/PHP-777BB4?logo=php&logoColor=white" alt="PHP">
  <img src="https://img.shields.io/badge/MySQL-4479A1?logo=mysql&logoColor=white" alt="MySQL">
  <img src="https://img.shields.io/badge/Tailwind%20CSS-06B6D4?logo=tailwindcss&logoColor=white" alt="Tailwind CSS">
</p>

# Voetbaltoernooi

Een webapp om een voetbaltoernooi te regelen. Teams schrijven zich in met hun spelers, de organisatie plant de wedstrijden en vult de uitslagen in. Een admin en een gewone gebruiker zien elk hun eigen deel van de site.

## Functies

**Voor teams**
- Een team inschrijven met teamnaam, inloggegevens en spelers (`register.php`). Gebruiker, team en spelers worden in één transactie opgeslagen: lukt één stap niet, dan wordt niets bewaard.
- Een eigen dashboard met de geplande wedstrijden en uitslagen.
- Teams en hun spelers bekijken (`view_teams.php`).

**Voor de admin**
- Een beheerdersdashboard (`admin_.php`).
- Wedstrijden plannen tussen twee teams op een datum (`plan_matches.php`).
- Uitslagen invoeren (`enter_results.php`).

Na het inloggen stuurt de site je op basis van je rol naar het juiste dashboard. Wachtwoorden worden versleuteld opgeslagen met `password_hash`.

## Zelf draaien

Je hebt een lokale webserver met PHP en MySQL nodig, bijvoorbeeld XAMPP.

1. Clone het project in de map van je webserver:
   ```bash
   git clone https://github.com/ParisAngelopoulos/Voetbaltoernooi.git
   ```
2. Maak in phpMyAdmin een database aan met de naam `voetbaltoernooi`.
3. Importeer daarin het bestand `voetbaltoernooi (2).sql`.
4. Ga naar http://localhost/Voetbaltoernooi en log in.

De verbinding met de database staat in `database_connection.php`.

### Testaccounts

In de database staan drie accounts om mee te proberen:

| Rol | Gebruikersnaam | Wachtwoord |
| --- | --- | --- |
| Admin | `admin` | `password` |
| Team | `paris` | `paris` |
| Team | `peter` | `peter` |

## Database

| Tabel | Wat erin staat |
| --- | --- |
| `users` | Accounts, met rol `admin` of `user` |
| `teams` | Teams, gekoppeld aan het account dat ze heeft ingeschreven |
| `players` | Spelers per team |
| `matches` | Wedstrijden: twee teams, een datum en de uitslag |

---

Gemaakt door **Paris Angelopoulos**, web developer in opleiding · [GitHub](https://github.com/ParisAngelopoulos) · [parisangelopoulos@gmail.com](mailto:parisangelopoulos@gmail.com)
