import { initializeApp } from 'firebase/app';
import { getMessaging, getToken } from "firebase/messaging";

// Your web app's Firebase configuration
const firebaseConfig = {
    apiKey: "AIzaSyAten68jj8okyj9dh28AdcQtvcARaFobxE",
    authDomain: "hypair-imt.firebaseapp.com",
    projectId: "hypair-imt",
    storageBucket: "hypair-imt.appspot.com",
    messagingSenderId: "660536529270",
    appId: "1:660536529270:web:ee417a724f84eca627aa57"
};

// Initialize Firebase
const app = initializeApp(firebaseConfig);

// Initialize Firebase Cloud Messaging and get a reference to the service
const messaging = getMessaging(app);


//On récupère la variable d'environnement stockée dans la window
const FCM_VAPID_PUBLIC_KEY = window.FCM_VAPID_PUBLIC_KEY
getToken(messaging, {vapidKey: FCM_VAPID_PUBLIC_KEY }).then((currentToken) => {  
    if (currentToken) {
      console.log("Current token : " + currentToken)
      // Send the token to your server and update the UI if necessary
      fetch("/souscrire", {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json',
          'X-CSRF-Token': document.querySelector('meta[name="csrf_token"]').content
        },
        body: JSON.stringify({
          topics: ['posts', 'events'],
          token: currentToken
        })
      }).then( console.log("Souscription aux notifications réussie") )
    } else {
      // Show permission request UI
      console.log('No registration token available. Request permission to generate one.');
      // ...
    }
  }).catch((err) => {
    console.log('An error occurred while retrieving token. ', err);
    // ...
  });
