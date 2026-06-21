# 🌟 Luminaire

Platform AI chatbot untuk teman curhat dan konseling ringan, dibangun dengan Laravel 13 & Groq API.

🔗 **Live Demo:** https://project-luminaire-production.up.railway.app

---

## 🚀 Features

- 💬 Chat dengan AI Persona (Kak Ara & Kak Reza)
- 🎨 Custom Character dengan upload avatar
- 🚩 Sistem flagging kata kunci spesifik
- 🛡️ Admin Panel (Filament)

## ❌ Not Implemented

- 📊 Mood Tracker
- 📓 Journals
- 🔔 Notifikasi Admin jika ada konten yang ke flag
- 📧 Reset Password Lewat Email
- 📃 Admin Panel : Total Flagged Content, Sorting Flagged Content, Graph Mood User
- 🚨 Terms of Service Page

## 💡 Possible Ideas

- 🌆 AI Chatbots can send pre-determined images from the database from triggering specific keywords
- 🎁 Reward System for Users

---

## 🧪 QA Testing Checklist

### User Flow
- [x] Register akun baru
- [x] Login
- [x] Chat dengan Kak Ara
- [x] Chat dengan Kak Reza
- [x] Buat Custom Character (dengan upload avatar)
- [x] Chat dengan Custom Character
- [x] Reset chat / New Chat
- [x] Edit Custom Character
- [x] Delete Custom Character
- [x] Logout

### Admin Flow
- [x] Masuk Admin Panel (Filament)
- [x] Fitur Flagging

---

## 🛠️ Tech Stack

- **Backend:** Laravel 13
- **AI:** Groq API (LLaMA 3.3 70B)
- **Admin Panel:** Filament
- **Hosting:** Railway
- **Database:** MySQL

---