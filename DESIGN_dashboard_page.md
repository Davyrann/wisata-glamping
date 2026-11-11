# DESIGN.md — Atara Glamping: Account & Booking Dashboard

Design system for the logged-in guest area of **atara.delapanbit.my.id** (Laravel 12 + Blade + Tailwind CSS v4).
Scope: account, booking list, booking detail, digital QR card, payment, cancellation/refund, profile.
Audience for this file: coding agents. Follow it literally. If a rule here conflicts with a default, this file wins.

---

## 1. Product context

- Atara Glamping: 3 room types, nightly rental, mountain/pine-forest retreat at 1.620 mdpl.
- Rooms: Safari Luxury Suite (Rp 850.000/night, 2–4 guests), Alpine Geodesic Dome (Rp 1.100.000/night, 2 guests), Bell Tent Pine Retreat (Rp 650.000/night, 2–3 guests).
- One main room per booking. Check-in 14.00 WIB, check-out 12.00 WIB.
- Optional cancellation insurance: flat Rp 25.000 (non-refundable premium).
- No damage deposit.
- Payment: QRIS (sandbox). Unpaid slot is held for **15 minutes**.
- Total = (room rate × nights) + insurance premium (optional).
- Booking statuses: `unpaid` → `confirmed` → `checked_in` → `completed`. Extra terminal states: `cancelled`, `refunded`, `expired`.
- Guests can also track a booking **without login** via booking code + email/phone. The dashboard is the logged-in version of that.
- The same login serves staff and guests. This file covers the **guest** experience; staff screens reuse the same shell and tokens.

**Mood:** calm, warm, quiet confidence. A well-run mountain lodge front desk, not a SaaS admin panel. Information first, decoration last.

---

## 2. Design principles

1. **One job per screen.** Each page answers one question: "What are my bookings?", "What do I do next for this one?", "Where is my QR card?".
2. **Status is the main character.** A guest should know the state of a booking in under one second (color + icon + label, never color alone).
3. **Next action is always visible.** Every booking shows exactly one primary action matching its status (see §9).
4. **Money is explicit.** Always show the formula and the total. No hidden fees, no surprise rows.
5. **Light-first, dark-chrome.** Content area is light paper; sidebar and top bar use the site's dark ink (`#161816`) to tie back to the marketing site.
6. **Anti-slop.** No purple/blue gradients, no glassmorphism, no emoji as icons, no stock "dashboard hero" illustrations, no gradient text, no 3-equal-cards-with-icon filler, no decorative blobs. Every element must carry information or aid navigation.

---

## 3. Color tokens

> Only `#161816` is taken from the live site (`theme-color`). All other values are a proposed palette built to match its pine-forest / mountain-mist mood. Adjust to the real brand CSS if it differs.

```css
@theme {
  /* Ink (dark chrome) */
  --color-ink-950: #0F110F;
  --color-ink-900: #161816;   /* sidebar, top bar — matches site theme-color */
  --color-ink-800: #20231F;
  --color-ink-700: #2E322D;

  /* Paper (light content) */
  --color-paper:    #F6F4EE;  /* app background */
  --color-surface:  #FFFFFF;  /* cards, tables, forms */
  --color-sunken:   #EFECE3;  /* table headers, inset areas */
  --color-line:     #E2DED2;  /* 1px borders */
  --color-line-strong: #CFCABA;

  /* Text */
  --color-text:       #1B1D1A;
  --color-text-muted: #5E625A;
  --color-text-faint: #8A8E84;
  --color-text-on-ink: #E9E7DF;

  /* Brand */
  --color-pine-700: #2C4636;  /* primary buttons, links */
  --color-pine-600: #365642;  /* hover */
  --color-pine-100: #DDE7DF;  /* tints */
  --color-ember-600: #B4622F; /* single warm accent: key CTA highlight, QR card edge */
  --color-ember-100: #F3E2D5;

  /* Status */
  --color-unpaid-fg:    #8A5A00;  --color-unpaid-bg:    #FBEFD2;
  --color-confirmed-fg: #1F5C3A;  --color-confirmed-bg: #DCEFE2;
  --color-checkedin-fg: #1D4E6B;  --color-checkedin-bg: #DCEAF2;
  --color-completed-fg: #4A4E46;  --color-completed-bg: #E7E5DC;
  --color-cancelled-fg: #7A2E2A;  --color-cancelled-bg: #F4DDDA;
  --color-refunded-fg:  #5B3E7A;  --color-refunded-bg:  #EADFF2;  /* only place purple is allowed */
  --color-expired-fg:   #6B6F66;  --color-expired-bg:   #ECEAE2;

  /* Feedback */
  --color-danger:  #A93A33;
  --color-success: #1F5C3A;
  --color-focus:   #2C4636;
}
```

Rules:
- Max **one** accent per screen region. Pine = action, Ember = emphasis (countdown, QR card edge, "Paling Diminati"-style highlights). Never use both on the same button.
- Body text on `paper`/`surface` must be ≥ 4.5:1 contrast. Verify status pairs.
- Never use pure black or pure white text on tinted backgrounds; use the tokens above.

---

## 4. Typography

| Role | Font | Notes |
|---|---|---|
| Display / page titles / booking code | **Fraunces** (variable, opsz) | Warm serif, weight 500–600. Use sparingly: page title, room name, big totals. |
| UI / body / tables / forms | **Plus Jakarta Sans** | Weights 400/500/600. Tabular numbers on all money and dates. |
| Mono (booking code, QR value) | **JetBrains Mono** | Weight 500, letter-spacing `0.04em`. |

Fallbacks: `Georgia, serif` / `ui-sans-serif, system-ui, sans-serif` / `ui-monospace, monospace`.

Scale (rem): `xs 0.75 · sm 0.875 · base 1 · lg 1.125 · xl 1.375 · 2xl 1.75 · 3xl 2.25`.
- Page title: `2xl`, Fraunces 600, tracking `-0.01em`.
- Section title: `lg`, Plus Jakarta 600.
- Table text: `sm`. Caption/meta: `xs`, `text-muted`.
- Money and dates: `font-variant-numeric: tabular-nums`.
- Line height: body 1.55, headings 1.2.
- All UI copy is **Bahasa Indonesia**, sentence case. No ALL CAPS except tiny `xs` overline labels (max 3 words).

Money format: `Rp 1.100.000` (dot thousands, space after `Rp`). Dates: `12 Des 2026`, with weekday where helpful (`Sab, 12 Des 2026`). Times: `14.00 WIB`.

---

## 5. Layout & spacing

- Spacing scale: 4px base → `1 4 · 2 8 · 3 12 · 4 16 · 5 20 · 6 24 · 8 32 · 10 40 · 12 48`.
- Radius: `sm 6px` (inputs, badges), `md 10px` (cards, buttons), `lg 14px` (modals, QR card). No fully pill-shaped buttons; pills only for status badges.
- Borders over shadows: cards use `1px solid var(--color-line)`. Shadow allowed only on dropdowns/modals: `0 8px 24px rgb(22 24 22 / 0.12)`.
- Content max width: `1120px`, centered inside the main area. Forms and detail text max `640px`.

**App shell (desktop ≥ 1024px)**
- Left sidebar 248px, `ink-900`, text `text-on-ink`. Logo mark (Atara "A" tent) top, nav below, account chip at bottom.
- Top bar 56px, `paper`, 1px bottom `line`. Left: page title/breadcrumb. Right: "Pesan lagi" button, notifications (only if there are any), avatar menu.
- Main: `paper` background, padding `32px`.

**Tablet 640–1023px:** sidebar collapses to icon rail (64px).
**Mobile <640px:** sidebar becomes a bottom tab bar (4 items: Ringkasan, Pesanan, Kartu QR, Akun). Tables become stacked cards. Primary action sticks to the bottom (`safe-area-inset-bottom` respected).

Navigation items (sidebar):
1. Ringkasan (`/dashboard`)
2. Pesanan Saya (`/dashboard/bookings`)
3. Kartu Digital (`/dashboard/cards`)
4. Pembayaran (`/dashboard/payments`)
5. Profil & Keamanan (`/dashboard/account`)
6. Bantuan (opens WhatsApp concierge, external icon)

Active item: `ink-800` background, 2px `ember-600` left bar, text white. Icon set: **Lucide**, 20px, stroke 1.75. Icons always paired with text labels in the sidebar.

---

## 6. Components

### 6.1 Buttons
- **Primary:** `pine-700` bg, white text, `md` radius, height 40px (44px on mobile), padding `0 16px`, weight 600. Hover `pine-600`. Focus ring: 2px `focus` + 2px offset `paper`.
- **Secondary:** `surface` bg, 1px `line-strong` border, `text`. Hover `sunken`.
- **Ghost:** transparent, `pine-700` text, underline on hover.
- **Destructive:** `surface` bg, `danger` text and border; fills `danger` only inside the confirm modal.
- Disabled: 45% opacity, `cursor-not-allowed`, and a visible reason in helper text (never silently disabled).
- Loading: spinner replaces icon, label stays, width does not change.

### 6.2 Status badge
Pill, height 24px, padding `0 10px`, `xs` weight 600, with a 6px dot (or icon) in the same `fg` color.

| Status | Label (ID) | Icon |
|---|---|---|
| `unpaid` | Menunggu pembayaran | `clock` |
| `confirmed` | Terkonfirmasi | `check-circle-2` |
| `checked_in` | Sedang menginap | `tent` |
| `completed` | Selesai | `flag` |
| `cancelled` | Dibatalkan | `x-circle` |
| `refunded` | Dana dikembalikan | `undo-2` |
| `expired` | Kedaluwarsa | `timer-off` |

### 6.3 Booking card (list item)
`surface`, 1px `line`, `md` radius, padding 20px. Layout (desktop, 3 zones):
- **Left (thumbnail 96×72, `sm` radius):** room photo from `/images/*`.
- **Middle:** room name (Fraunces `lg`), dates line `Sab, 12 Des – Min, 13 Des 2026 · 1 malam`, guests count, booking code in mono (`xs`, `text-muted`).
- **Right:** status badge, total in tabular numerals, then the **one primary action**.
Hover: border `line-strong` only. No lift, no scale.

### 6.4 Data table (booking history, payments)
Header row `sunken`, `xs` uppercase-free semibold `text-muted`. Row height 56px, hairline separators, no zebra. Sortable columns show a chevron. Row click opens detail. Empty and loading states are required (see §10).

### 6.5 Booking timeline (stepper)
Horizontal on desktop, vertical on mobile. Four fixed steps: **Dipesan → Dibayar → Check-in → Selesai**. Completed steps: `pine-700` filled node with check. Current: ring `ember-600`. Future: `line-strong` outline. Each step shows timestamp when reached. Cancelled/expired replace remaining steps with one red/grey terminal node.

### 6.6 Payment countdown (unpaid only)
Banner at top of booking detail: `unpaid-bg`, 1px `unpaid-fg` at 30%, clock icon, text "Selesaikan pembayaran dalam **14:32**" (mono, tabular). Ember progress bar underneath (shrinks). At 0:00 the page swaps to the `expired` state without reload. Announce at 5:00 and 1:00 via `aria-live="polite"`.

### 6.7 QRIS payment panel
Two columns on desktop: QR (240px, white tile with 16px padding, 1px `line`) and a summary card. Label "QRIS Sandbox — tidak ada biaya sungguhan" in a small `sunken` note. Button "Saya sudah membayar (simulasi)" primary. After success: inline success state, then redirect to booking detail with confetti **disabled** (anti-slop); use a quiet check animation (≤ 300ms).

### 6.8 Digital QR card (hero element of the dashboard)
The one place that may feel "designed". Ticket shape: `lg` radius, `ink-900` background, `text-on-ink`, 3px `ember-600` top edge.
- Left: room name (Fraunces `xl`), guest name, dates, "Check-in 14.00 · Check-out 12.00 WIB".
- Right: white 160px QR tile.
- Bottom strip (dashed divider): booking code in mono `lg`, tap to copy.
- Actions: "Unduh PNG", "Tambah ke Wallet" (only if implemented), "Cetak".
- Visible only when status is `confirmed` or `checked_in`. For other states show a locked placeholder explaining why.
- Increase brightness hint on mobile: show "Naikkan kecerahan layar saat scan" caption.

### 6.9 Price breakdown
Definition list, right-aligned tabular numbers:
```
Safari Luxury Suite × 2 malam      Rp 1.700.000
Asuransi Pembatalan                Rp    25.000
────────────────────────────────────────────────
Total dibayar                      Rp 1.725.000   (Fraunces xl)
```
Always include the line "Tidak ada deposit jaminan" in `text-muted` `xs` under the total.

### 6.10 Forms
- Labels above inputs, `sm` weight 500. Helper text below in `text-muted`. Errors in `danger` with icon, never red border alone.
- Input height 44px, `sm` radius, 1px `line-strong`, focus ring as buttons. Placeholder `text-faint`.
- Phone input: `+62` prefix chip. Email and phone validated inline on blur, not on every keystroke.
- Insurance toggle: a real checkbox row (not a switch) with price and one-line benefit; opens a "Lihat skema refund" disclosure showing the refund table.

### 6.11 Modals & confirmations
Used only for cancellation and logout-all-devices. Width 480px, `lg` radius, scrim `ink-950` at 50%. Title states the consequence ("Batalkan pesanan ini?"). Body states money outcome in plain numbers. Buttons: Ghost "Kembali" + Destructive "Ya, batalkan".

### 6.12 Toasts
Bottom-right desktop, bottom-center mobile. Max 1 visible, 5s, `ink-900` bg, white text, status icon. Never the only record of an important event (also log it on the page).

---

## 7. Pages

### 7.1 Ringkasan `/dashboard`
1. Greeting line: "Halo, {firstName}" (Fraunces `2xl`) + one-line context ("1 pesanan akan datang").
2. **Next stay card** (largest element): next upcoming booking with timeline, QR card shortcut, and primary action. If none: empty state with "Pilih kamar" CTA.
3. Two compact stat tiles max: "Pesanan aktif", "Total menginap". No decorative charts.
4. "Pesanan terbaru" table (last 3) with link "Lihat semua".
5. Help strip: WhatsApp concierge `+62 812-3456-7890`, hours 08.00–20.00 WIB.

### 7.2 Pesanan Saya `/dashboard/bookings`
- Tabs with counts: **Akan datang · Berlangsung · Selesai · Dibatalkan**.
- Filter row: search by booking code, date range, room type. Sticky on scroll.
- List of booking cards (6.3). Pagination 10/page.

### 7.3 Detail Pesanan `/dashboard/bookings/{code}`
Two-column (main 2/3, aside 1/3):
- Main: status header (badge + code + copy), countdown banner if unpaid, timeline, stay details (room, dates, nights, guests), guest contact, room facilities included (listrik 24 jam, air panas, sarapan alpine, perapian).
- Aside (sticky): price breakdown, primary action, secondary actions, policy summary.
- Footer of page: refund policy summary and "Hubungi concierge".

### 7.4 Kartu Digital `/dashboard/cards`
Grid of QR cards for `confirmed`/`checked_in` bookings (1 col mobile, 2 col desktop). Empty state explains that cards appear after payment.

### 7.5 Pembayaran `/dashboard/payments`
Table: date, booking code, method (QRIS), amount, status (Berhasil / Menunggu / Gagal / Dikembalikan). Row opens payment receipt (printable, mono code, formula).

### 7.6 Profil & Keamanan `/dashboard/account`
Sections as stacked cards, each with its own Save button: Data diri (nama, email, telepon) · Kata sandi · Sesi perangkat · Hapus akun (danger zone at the bottom, requires typing the email).

### 7.7 Login / register `/login`
Split layout on desktop: left 5/12 is a full-height photo (`Camp_premium.jpg`) with a single caption "Lanskap Pagi Hari — 1.620 mdpl"; right 7/12 `paper` with a 400px form. Fields: email, password, "Ingat saya", link "Lupa kata sandi". Secondary link: "Cek booking tanpa login" → `#cek-reservasi`. Mobile: photo becomes a 160px header band.

---

## 8. Status → permitted actions

| Status | Primary action | Secondary | Visible extras |
|---|---|---|---|
| `unpaid` | **Bayar sekarang** | Batalkan | Countdown banner, QRIS panel |
| `confirmed` | **Lihat kartu QR** | Ajukan pembatalan, Ubah kontak | Refund simulator |
| `checked_in` | **Lihat kartu QR** | Hubungi concierge | Check-out time reminder |
| `completed` | **Pesan lagi** (prefill same room) | Unduh kuitansi | — |
| `cancelled` | Pesan lagi | Lihat kuitansi | Cancellation reason |
| `refunded` | Lihat kuitansi | Pesan lagi | Refund amount + date |
| `expired` | **Pesan ulang** (prefill) | — | "Slot dilepas setelah 15 menit" |

Cancellation is only offered **before check-in** (status `unpaid` or `confirmed`).

### Refund simulator (inside the cancel modal)
Compute live from today's date vs check-in date; show a sentence plus numbers.

| Time before check-in | With insurance | Without insurance |
|---|---|---|
| More than 3 days | Refund 100% of room fee; Rp 25.000 premium not refunded | Refund 0% |
| 3 days or less | Refund 50% of room fee; Rp 25.000 premium not refunded | Refund 0% |

Example copy: "Anda akan menerima Rp 850.000 (50% dari biaya sewa). Premi asuransi Rp 25.000 tidak dikembalikan."
After submit, status stays `confirmed` with a "Menunggu persetujuan staf" chip until staff approves, then becomes `cancelled` → `refunded`.

---

## 9. Content & tone

- Voice: warm, plain, respectful ("Anda"). Short sentences. No hype words ("luar biasa!", "sensasional").
- Buttons are verbs: "Bayar sekarang", "Ajukan pembatalan", "Unduh kartu".
- Error copy states what happened + what to do: "Pembayaran belum terdeteksi. Coba lagi dalam 1 menit atau hubungi concierge."
- Never expose internal terms (sandbox only where relevant to QRIS, `checked_in`, enum names).

---

## 10. States (every data view needs all four)

| State | Treatment |
|---|---|
| Loading | Skeleton blocks matching final layout, `sunken` with slow 1.4s shimmer (disabled under reduced motion) |
| Empty | One line explaining why + one action. No illustration; at most a 40px Lucide icon in `text-faint` |
| Error | Inline card with `cancelled-bg`, message, "Coba lagi" button, support link |
| Offline | Top banner "Anda sedang offline. Data terakhir ditampilkan." |

---

## 11. Motion

- Durations: 120ms (hover/press), 200ms (disclosure, dropdown), 300ms max (page-level). Easing `cubic-bezier(0.2, 0, 0, 1)`.
- Animate only `opacity`, `transform`, `background-color`. No parallax, no bounce, no looping decorative animation.
- Respect `prefers-reduced-motion`: remove shimmer, countdown bar animates in discrete steps.

---

## 12. Accessibility

- WCAG 2.2 AA. Visible focus on every interactive element. Tap targets ≥ 44px.
- Status always conveyed by label + icon + color.
- QR image has `alt="Kode QR booking {code}"` and the code is selectable text beside it.
- Tables have `<caption class="sr-only">`; mobile card view keeps the same reading order.
- Forms: associated labels, `aria-describedby` for hints/errors, error summary focused on submit failure.
- Countdown: `role="timer"`, polite announcements only at thresholds.

---

## 13. Implementation notes (Laravel 12 + Blade + Tailwind v4)

- Tokens live in `resources/css/app.css` inside `@theme { ... }`. Use utilities like `bg-paper`, `text-text-muted`, `border-line`. Do not hardcode hex values in Blade.
- Build Blade components under `resources/views/components/ui/`: `button`, `badge`, `card`, `stat`, `table`, `timeline`, `price-breakdown`, `qr-card`, `modal`, `field`, `empty-state`.
- Status mapping lives in one place (`App\Enums\BookingStatus` with `label()`, `badgeClasses()`, `icon()`, `actions()`). Never branch on status strings inside views.
- Money via a single helper `rupiah(int $amount)`. Dates via Carbon with `id` locale and `Asia/Jakarta`.
- QR: generate server-side as SVG; the encoded value is the booking code only (no personal data).
- Countdown driven by a server-provided `expires_at` timestamp, not by client clock arithmetic alone; revalidate on focus.
- Use Alpine.js (or plain JS) for tabs, modals, and countdown. No heavy SPA framework.
- Images: reuse `/images/Camp_premium.jpg`, `Camp_with_chair.jpg`, `Camp_from_above.jpg`, `High_standart_camp.jpg` with `loading="lazy"` and explicit width/height.

---

## 14. Do / Don't checklist

**Do**
- Show the next action and the money outcome before asking for confirmation.
- Keep the QR card and countdown as the only expressive elements.
- Reuse the same booking card and badge everywhere.

**Don't**
- Add gradients, glass blur, neon glows, or emoji icons.
- Use more than two font families plus mono, or more than one accent per region.
- Hide the refund rule behind a link when the user is about to cancel.
- Use toasts as the only confirmation of payment or cancellation.
- Invent new statuses, colors, or button styles outside this file.