# Melt&More-Database-Project
<div align="center">

<!-- HEADER BANNER -->
<img src="docs/images/post1_overview.png" alt="Melt & More — DBMS Project" width="100%"/>

<br/>

# 🎂 Melt & More — Sweet Bakery
### Online Order Management System

[![DBMS Project](https://img.shields.io/badge/Subject-Database%20Management%20Systems-blue?style=for-the-badge&logo=mysql)](https://github.com)
[![Semester](https://img.shields.io/badge/Semester-4th%20%7C%20BSAI-purple?style=for-the-badge)](https://github.com)
[![University](https://img.shields.io/badge/University-Riphah%20International-green?style=for-the-badge)](https://riphah.edu.pk)
[![Status](https://img.shields.io/badge/Status-Completed-success?style=for-the-badge)](https://github.com)

> **A real bakery. A real problem. A real database solution.**  
> Built to digitize and automate the daily operations of *Melt & More* — a home-based bakery in Sahiwal, Punjab.

</div>

---

## 👩‍💻 Built By

| Developer | Details |
|-----------|---------|
| **Malayika Tahir** | BS Artificial Intelligence · BSAI-A · CMS ID: F24-BSAI-0009 · CGPA: 4.0 · Owner & Baker at Melt & More |
| **Mahnoor Ali Bahadur** | BS Artificial Intelligence · BSAI-A · Riphah International University, Sahiwal |

🏛️ **Riphah International University, Sahiwal** — 4th Semester DBMS Project

---

## 📌 Table of Contents

- [The Real Problem](#-the-real-problem)
- [Project Overview](#-project-overview)
- [Live System Features](#-live-system-features)
- [Database Design](#-database-design)
- [Tech Stack](#-tech-stack)
- [System Screenshots](#-system-screenshots)
- [How It Works](#-how-it-works)
- [Setup & Installation](#-setup--installation)
- [About the Developer](#-about-the-developer)

---

## ⚠️ The Real Problem

<img src="docs/images/post2_problem.png" alt="The Real Problem — Before the System" width="100%"/>

Before this system existed, Malayika managed her bakery entirely by hand across **4 platforms simultaneously**:

| # | Problem | Impact |
|---|---------|--------|
| 01 | **Orders on 4 Platforms** — TikTok, Instagram, YouTube, WhatsApp | Orders were getting lost — no central record |
| 02 | **Payments Untracked** — advance payments written in notebooks | Customers denied paying · Revenue lost |
| 03 | **No Inventory System** — ingredients ran out before delivery day | No alerts, no minimum-stock warnings |
| 04 | **Zero Order History** — repeat customers explained preferences every time | No loyalty tracking whatsoever |

> *"This was Malayika's real daily struggle — until the **Database** changed everything."*

---

## 🏠 Project Overview

<img src="docs/images/post1_overview.png" alt="Project Overview" width="100%"/>

**Melt & More Sweet Bakery** is a Database Management System designed to digitize and automate bakery operations. It replaces manual chats and diaries with a centralized system to manage orders, customers, products, and sales efficiently and accurately.

### 🔑 Key Features

| Feature | Description |
|---------|-------------|
| 👥 Customer & Order Management | Full customer profiles + order lifecycle tracking |
| 🎂 Menu & Product Management | Add, edit, delete cakes with category & pricing |
| 📊 Sales & Revenue Tracking | Monthly revenue, best sellers, daily summaries |
| 🗄️ Centralized MySQL Database | All data in one place — no more notebooks |
| 📋 Accurate Reports & Analytics | Real-time insights for better business decisions |

### 🏆 Project Highlights

| ✅ Complete User-Friendly Interface | ⏱️ Reduces Manual Work & Saves Time |
|---|---|
| 🛡️ Accurate & Secure Data Handling | 📈 Real-time Reports & Better Insights |

---

## 🖥️ Live System Features

### 01 — Customer Website Homepage

<img src="docs/images/post3_homepage.png" alt="Customer Website Homepage" width="100%"/>

What customers see when they visit:

- 🎂 **Welcome Hero** — Beautiful homepage with cake gallery & CTA buttons
- 🧭 **Easy Navigation** — Home · Menu · About Us · Contact · My Account
- 🛒 **Order Now Button** — Direct to ordering form, one click to place order
- 📖 **View Menu Button** — Browse all cakes by category with prices

**Our Brand Values:**

| 👑 Tradition | ⭐ Quality | 🎨 Creativity | ❤️ Passion |
|---|---|---|---|
| Every cake follows time-honoured homemade recipes | Premium-grade ingredients, no artificial flavours | Every order is unique — custom designs & decorations | Baking is not just a craft, it is a calling |

---

### 02 — Dynamic Menu with Categories, Prices & Ordering

<img src="docs/images/post4_menu.png" alt="Menu Page" width="100%"/>

| Product | Category | Price |
|---------|----------|-------|
| 1 Pound Vanilla Cake | Occasion Cakes | Rs. 1,400 |
| 2 Pound Chocolate Cake | Occasion Cakes | Rs. 2,400 |
| Cupcakes — 6 Pieces | Cupcakes | Rs. 1,000 |
| Chocolate Mousse | Desserts | Rs. 350 |
| Red Velvet Cake | Occasion Cakes | Rs. 1,600 |

**Order Tracking Flow:**
```
Pending ──► Confirmed ──► Preparing ──► Delivered ──► (Cancelled)
```
Track by Order Number (MM-YYYY-XXXX) + Phone Number — no login required.

---

### 03 — Authentication — Login & Register

<img src="docs/images/post5_auth.png" alt="Authentication System" width="100%"/>

**3 Types of Users — Each with Their Own Access:**

| 👤 Customer Login | 👤➕ Register | 🛡️ Admin Login |
|---|---|---|
| Browse menu & place orders | Create new account | Full system access |
| Track order status | Name, email, phone | Manage orders & products |
| View order history | Password stored hashed | Inventory control |

**Database Behind Login:**
- `users` table — id · name · email (UNIQUE) · phone · password · created_at
- `admins` table — id · username · password · full_name · created_at

---

### 04 — Admin Dashboard — Full Control

<img src="docs/images/post6_dashboard.png" alt="Admin Dashboard" width="100%"/>

Real-time overview of the entire bakery system:

```
📦 8 Products    📋 3 Orders    ⏳ 1 Pending    💰 Rs. 6,200 Revenue
```

**Module Breakdown:**

| Module | Function |
|--------|----------|
| 🏠 Dashboard | Real-time statistics & overview |
| 🎂 Cakes & Products | Add, edit & delete cakes |
| 📋 All Orders | View & filter all customer orders |
| ⏳ Pending Orders | Action needed on pending orders |
| 🥚 Ingredients | Manage stock & ingredients |

---

### 05 — Database Design

<img src="docs/images/post7_database.png" alt="Database Design" width="100%"/>

---

### 06 — Products & Inventory Management

<img src="docs/images/post8_inventory.png" alt="Products and Inventory" width="100%"/>

**Live Stock Tracking — Quantity vs MIN_STOCK Threshold:**

| Ingredient | Current Stock | Min Stock | Status |
|-----------|--------------|-----------|--------|
| All Purpose Flour | 5,000g | 1,000g | ✅ OK |
| Baking Powder | 500g | 100g | ✅ OK |
| Butter | 2,000g | 300g | ✅ OK |
| Cocoa Powder | 1,000g | 200g | ✅ OK |
| Eggs | 48 pcs | 12 pcs | ✅ OK |

---

## 🗄️ Database Design

**Database:** `melt_and_more` — MySQL via XAMPP — **5 Normalized Tables — 128KB Total**

```sql
-- 01. admins
CREATE TABLE admins (
    id          INT AUTO_INCREMENT PRIMARY KEY,
    username    VARCHAR(100) UNIQUE NOT NULL,
    password    VARCHAR(255) NOT NULL,
    full_name   VARCHAR(100),
    created_at  TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- 02. users
CREATE TABLE users (
    id          INT AUTO_INCREMENT PRIMARY KEY,
    name        VARCHAR(100) NOT NULL,
    email       VARCHAR(100) UNIQUE NOT NULL,
    phone       VARCHAR(20),
    password    VARCHAR(255) NOT NULL,
    created_at  TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- 03. cakes
CREATE TABLE cakes (
    id           INT AUTO_INCREMENT PRIMARY KEY,
    name         VARCHAR(100) NOT NULL,
    category     VARCHAR(50),
    price        DECIMAL(10,2) NOT NULL,
    unit         VARCHAR(30),
    image_url    VARCHAR(255),
    is_available TINYINT(1) DEFAULT 1
);

-- 04. ingredients
CREATE TABLE ingredients (
    id          INT AUTO_INCREMENT PRIMARY KEY,
    name        VARCHAR(100) NOT NULL,
    quantity    DECIMAL(10,2) DEFAULT 0,
    unit        VARCHAR(20),
    min_stock   DECIMAL(10,2) DEFAULT 0,
    created_at  TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- 05. orders
CREATE TABLE orders (
    id             INT AUTO_INCREMENT PRIMARY KEY,
    order_number   VARCHAR(30) UNIQUE NOT NULL,  -- e.g. MM-2026-0123
    customer_name  VARCHAR(100) NOT NULL,
    cake_name      VARCHAR(100) NOT NULL,
    quantity       INT NOT NULL,
    total_amount   DECIMAL(10,2),
    delivery_date  DATE,
    status         ENUM('Pending','Confirmed','Preparing','Delivered','Cancelled')
                   DEFAULT 'Pending',
    created_at     TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
```

**Database Features Used:**

| 🔑 AUTO_INCREMENT | 🔒 UNIQUE Constraint | 📋 ENUM Status | 🕐 DEFAULT Timestamps | 🗄️ InnoDB Engine |
|---|---|---|---|---|
| Primary Keys | Data Integrity | Order Tracking | Auto Date & Time | Reliable & Safe |

---

## ⚙️ How It Works

```
┌─────────────────────────────────────────────────────┐
│                                                     │
│  Customer places    Data stored in    System        │
│  an order      ──►  centralized   ──► processes &  │
│                     MySQL DBMS       manages auto  │
│                                          │          │
│                                          ▼          │
│                                   Reports & alerts  │
│                                   for better        │
│                                   decision making   │
└─────────────────────────────────────────────────────┘
```

---

## 🛠️ Tech Stack

| Layer | Technology |
|-------|-----------|
| 🖥️ Frontend / UI | Java (NetBeans — Drag & Drop GUI) |
| 🗄️ Database | MySQL (via XAMPP / phpMyAdmin) |
| 🔗 DB Connection | JDBC (Java Database Connectivity) |
| ⚙️ Backend Logic | Java classes + SQL queries |
| 🌐 Web Frontend | PHP · HTML · CSS · JavaScript |

---

## 📁 Project Structure

```
MeltAndMore/
│
├── 📁 src/
│   ├── DBConnection.java          # JDBC connection class
│   ├── HomePage.java              # Main homepage with animations
│   ├── UserLogin.java             # Customer login
│   ├── AdminLogin.java            # Admin login
│   ├── NewOrderForm.java          # Place new order
│   ├── MenuPage.java              # Browse cake menu
│   ├── OrdersList.java            # All orders table
│   ├── CustomerForm.java          # Customer management
│   ├── InventoryForm.java         # Ingredient stock
│   └── AdminDashboard.java        # Admin control panel
│
├── 📁 lib/
│   └── mysql-connector-j-8.x.jar  # JDBC driver
│
├── 📁 database/
│   └── melt_and_more.sql          # Complete database schema + seed data
│
├── 📁 docs/
│   └── 📁 images/                 # Project screenshots & infographics
│       ├── post1_overview.png
│       ├── post2_problem.png
│       ├── post3_homepage.png
│       ├── post4_menu.png
│       ├── post5_auth.png
│       ├── post6_dashboard.png
│       ├── post7_database.png
│       └── post8_inventory.png
│
└── README.md
```

---

## 🚀 Setup & Installation

### Prerequisites
- Java JDK 17+
- NetBeans IDE 19+
- XAMPP (Apache + MySQL)
- MySQL Connector/J 8.x

### Steps

**1. Clone the repository**
```bash
git clone https://github.com/YOUR_USERNAME/melt-and-more.git
cd melt-and-more
```

**2. Start XAMPP**
```
Open XAMPP Control Panel
Start Apache → Start MySQL
```

**3. Create the database**
```bash
# Open phpMyAdmin → http://localhost/phpmyadmin
# Click "New" → name it: melt_and_more
# Go to Import tab → select database/melt_and_more.sql → click Go
```

**4. Configure DB connection**
```java
// src/DBConnection.java
private static final String URL  = "jdbc:mysql://localhost:3306/melt_and_more";
private static final String USER = "root";
private static final String PASS = "";  // XAMPP default — change if needed
```

**5. Add JDBC driver to NetBeans**
```
Right-click project → Properties
→ Libraries → Add JAR/Folder
→ Select: lib/mysql-connector-j-8.x.jar
```

**6. Run the project**
```
Right-click HomePage.java → Run File
```

---

## 👩‍🎓 About the Developer

<div align="center">

**Malayika Tahir**  
BS Artificial Intelligence Student  
Riphah International University, Sahiwal  
Program: BSAI-A · CMS ID: F24-BSAI-0009

</div>

- 🎓 Maintains a **4.0 CGPA**
- 🎂 **Owns and runs Melt & More Bakery** — a home-based bakery in Sahiwal, Punjab
- 📱 Takes orders through **TikTok · Instagram · YouTube · WhatsApp** (`@meltandmoresahiwal`)
- 🤖 Building practical **ML & AI skills** independently to complement university coursework
- 💼 Goal: career development and professional credibility in AI

---

<div align="center">

## 🌟 Project Outcomes

| ✅ Centralized order management | ✅ Payment tracking with proof |
|---|---|
| ✅ Real-time inventory alerts | ✅ Complete customer history |
| ✅ Monthly revenue reports | ✅ Admin dashboard with full CRUD |

---

*"A strong foundation for a powerful application."*  
**Well-Structured · Scalable · Normalized · Efficient**

---

**#DBMS #MySQL #JavaNetBeans #JDBC #PHP #BakeryManagement**  
**#BSAI #RiphahUniversity #MeltAndMore #DatabaseProject**

<br/>

Made with ❤️ and 🎂 by **Malayika Tahir & Mahnoor Ali Bahadur**  
BS Artificial Intelligence — 4th Semester — Riphah International University, Sahiwal

</div>
