
const firebaseConfig = {
  apiKey: "AIzaSyD6jjEkdPbHyIEX30iQeCB0175QcYKCnc8",
  authDomain: "simtbc.firebaseapp.com",
  projectId: "simtbc",
  storageBucket: "simtbc.firebasestorage.app",
  messagingSenderId: "816599455136",
  appId: "1:816599455136:web:be4b909d1758398ebf40c5",
  measurementId: "G-PRFFMS4CRZ",
};

firebase.initializeApp(firebaseConfig);

const messaging = firebase.messaging();

// Minta izin notifikasi dan ambil token
if ("serviceWorker" in navigator) {
  navigator.serviceWorker
    .register("/firebase-messaging-sw.js")
    .then((registration) => {
      console.log("Service Worker terdaftar dengan scope:", registration.scope);

      // Gunakan service worker untuk messaging
      messaging.useServiceWorker(registration);

      // Minta izin notifikasi dan ambil token
      return Notification.requestPermission();
    })
    .then((permission) => {
      if (permission === "granted") {
        return messaging.getToken({
          vapidKey:
            "BAvhjOM7351Zn4VF7FWqhmsxJt_wZwN8Z5V1nOTXuRns7Egn1ybYQdJ6-6lohYXjxt2BDU7N_2PM4dbDAkL1D20", // Ganti dengan VAPID key kamu
        });
      } else {
        throw new Error("Izin notifikasi ditolak.");
      }
    })
    .then((currentToken) => {
      if (currentToken) {
        console.log("Token FCM:", currentToken);
        // Kirim token ke backend jika perlu
      } else {
        console.log("Tidak ada token yang tersedia.");
      }
    })
    .catch((err) => {
      console.error(
        "Gagal mendapatkan token atau register service worker gagal:",
        err
      );
    });
}

// Tangani pesan foreground
messaging.onMessage((payload) => {
  console.log("Pesan foreground diterima: ", payload);
  // Bisa tampilkan notifikasi custom di sini jika ingin
});
