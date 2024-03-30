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

function urlBase64ToUint8Array(base64String) {
    const padding = '='.repeat((4 - base64String.length % 4) % 4);
    const base64 = (base64String + padding)
        .replace(/-/g, '+')
        .replace(/_/g, '/');
    
    const rawData = window.atob(base64);
    const outputArray = new Uint8Array(rawData.length);
    
    for (let i = 0; i < rawData.length; ++i) {
        outputArray[i] = rawData.charCodeAt(i);
    }
    return outputArray;
}


getToken(messaging, {vapidKey: "BGrucQeibNcJBs0BBB5pIUc-sjoOMS_CWS743c41mCL5LAswoHTn62OoFSIUuYyrGUukY2Y58D1UTo2Z5udHvcY" }).then((currentToken) => {
    if (currentToken) {
      // Send the token to your server and update the UI if necessary
      fetch("/api/souscrire-notifs", {
        method: 'post',
        body: JSON.stringify(currentToken)
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
