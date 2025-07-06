import { StrictMode } from 'react'
import { createRoot } from 'react-dom/client'
import App from './App.tsx'
import Home from './pages/home.tsx';
import {createBrowserRouter , RouterProvider} from "react-router-dom";
import {ClerkProvider} from "@clerk/clerk-react";

const publishableKey = import.meta.env.VITE_CLERK_PUBLISHABLE_KEY

if(!publishableKey) {
    console.log('Missing public key');
}

const routes = createBrowserRouter([
    { path: '/', element: <App />},
    { path: '/home' , element: <Home />}
]);


createRoot(document.getElementById('root')!).render(
  <StrictMode>
      <ClerkProvider publishableKey={publishableKey} >
          <RouterProvider router={routes} />
      </ClerkProvider>
  </StrictMode>
)
