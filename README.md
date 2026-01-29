
# 🏦 Vulnerable Banking Application — 63satsvulnbank

**An intentionally vulnerable PHP + MySQL online banking lab for ethical hacking, OWASP Top 10 learning, and VAPT training.**

This project simulates a real banking system packed with **multiple security vulnerabilities**, making it perfect for:

* Web Pentesting
* Cybersecurity Training
* Vulnerability Assessment Practice
* CTF Challenges
* University Labs
* Self-learning

> ⚠️ **WARNING:** This application is intentionally insecure.
> **DO NOT deploy on public servers. Use only inside isolated lab environments.**

---

## 🚀 Features & Vulnerabilities Included

### 🔐 Authentication

* SQL Injection login bypass
* User enumeration
* Weak session management
* Session fixation
* Missing rate-limit
* Insecure cookies

### 👤 User Account Vulnerabilities

* IDOR (view other users’ bank statements)
* Plaintext passwords
* Missing access control
* Password & email change CSRF
* File upload bypass (RCE via malicious image)

### 💸 Banking System Flaws

* Unauthorized fund transfers
* Balance manipulation
* Transaction tampering
* Account takeover
* Weak business logic

### 🧰 Admin Panel Vulnerabilities

* SQL injection in admin login
* No role-based access control
* User deletion without CSRF
* Sensitive data exposure
* Insecure admin pages

### 📰 Blog & Contact Page

* Stored XSS
* Reflected XSS
* SQL injection in blog pages
* OS command injection in contact form
* HTML injection

### 🐚 Server-Side Vulnerabilities

* Local File Inclusion (LFI)
* Log poisoning (RCE via `/var/log/apache2/access.log`)
* Broken access control paths
* Public unauthenticated edit pages

---

## 🐳 Run Using Docker
with **docker-compose**:

```
sudo apt install docker.io
sudo apt install -y docker-compose
git clone https://github.com/hacksudo/63satsvulnbank
cd 63satsvulnbank
sudo docker-compose up -d
```
### 📥 Pull the Image

```
docker pull hacksudo/63satsvulnbank
```

### ▶️ Run the Lab

```
docker run -d -p 80:80 --name vuln_bank hacksudo/63satsvulnbank
```

Or with **docker-compose**:

```
docker-compose up -d
```

By default, the web app is accessible at:

```
http://localhost
```

---

## 🔑 Default Credentials

### 👤 Users

| Username | Password |
| -------- | -------- |
| alice    | alice123 |
| bob      | bob123   |
| john     | john123  |

### 🛠 Admin

| Username | Password |
| -------- | -------- |
| admin    | admin123 |

---

## 📁 Project Structure

```
/admin         → Vulnerable admin panel
/css           → UI styling
/includes      → DB connection & utilities
/uploads       → File upload endpoint (vulnerable)
mysql-init     → init.sql (database seeding)
docker-compose.yml
Dockerfile
```

---

## ⚙️ Technology Stack

* PHP 7.4
* Apache
* MySQL 5.7
* TailwindCSS
* Docker / Docker Compose

---

## ⚠️ Disclaimer

This software is created **strictly for educational and research purposes.**
The author is **not responsible** for any misuse.
Run only in controlled environments.

---

## ⭐ Support & Credits

Made for the cybersecurity community by **Hacksudo**.
If you like the project, ⭐ star the repository on GitHub!

---
