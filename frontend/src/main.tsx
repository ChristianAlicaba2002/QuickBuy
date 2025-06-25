import { StrictMode } from 'react'
import { createRoot } from 'react-dom/client'
import './index.css'
import App from './App.tsx'
import {createBrowserRouter , RouterProvider} from "react-router-dom";
import {ClerkProvider} from "@clerk/clerk-react";
const PUSHLISH_KEY = import.meta.env.VITE_CLERK_PUBLISHABLE_KEY
if(!PUSHLISH_KEY) {
    console.log('Missing public key');
}

const routes = createBrowserRouter([
    { path: '/', element: <App />}
]);


createRoot(document.getElementById('root')!).render(
  <StrictMode>
      <ClerkProvider publishableKey={PUSHLISH_KEY} >
          <RouterProvider router={routes} />
      </ClerkProvider>
  </StrictMode>
)
