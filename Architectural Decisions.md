# 📋 Architectural Decisions - NewsRoom API

## 🎯 Decision: Article Creation Architecture

### ✅ **Chosen Approach:** 
Layered Architecture (Repository → Service → Controller)

---

## 🏗️ **Layer Responsibilities**

### **1️⃣ FormRequest Layer** 🟢
- **Responsibility:** Validation & Sanitization only
- **Why:** Single Responsibility Principle (SRP)
- **What it does:**
  - Validates incoming data
  - Sanitizes title & content
  - Checks tags existence

### **2️⃣ Controller Layer** 🔵
- **Responsibility:** HTTP handling only
- **Why:** Keep it thin (5-10 lines max)
- **What it does:**
  - Receives request
  - Calls service
  - Returns JSON response

### **3️⃣ Service Layer** 🟡
- **Responsibility:** Business logic
- **Why:** Reusable, testable, framework-independent
- **What it does:**
  - Orchestrates creation process
  - Handles transactions
  - Dispatches events

### **4️⃣ Repository Layer** 🟠
- **Responsibility:** Data access logic
- **Why:** Swap database easily, cache management
- **What it does:**
  - Database operations
  - Cache handling
  - Query optimization

---
## Decision 1
I decided to handle cache invalidation inside the model's booted function rather than using a separate class or observer, as the latter approach is heavier on the server.💛

## Decision 2

Initially, the requirement was to store articles, authors, and tags in a single cache key. So when retrieving them, I used a specific resource for that.

As I progressed through the requirements, I noticed that Version 1 and Version 2 were requested. Therefore, I created a separate controller and a separate resource for each version.🤔


## Decision 3

The section stating that published articles are visible to everyone, but the reader only sees the published ones, the author sees the published ones and what they wrote, and the admin sees all articles. This was requested in the requirements section of Middleware, but I thought it more appropriate to put it in  the model specific in booted function 🧐💛 .


## Decision 4

Created **Custom Rule Classes** for sanitization and validation of title and content 



