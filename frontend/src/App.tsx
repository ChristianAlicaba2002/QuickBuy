import {
  SignedIn,
  SignedOut,
  SignInButton,
  SignUpButton,
} from "@clerk/clerk-react";
import "./App.css";
import { useEffect } from "react";
import { useNavigate } from "react-router-dom";

function AuthRedirect() {
  const navigate = useNavigate();
  useEffect(() => {
    navigate("/home");
  });
  return null;
}

function App() {
  return (
    <div className="main-container">
      <div className="container">
        <h1>QuickBuy</h1>
        <p>
          Is a streamlined and user-friendly ordering system designed to
          simplify the process of purchasing products online. Built for
          efficiency and speed, <b>QuickBuy</b> offers a seamless experience for
          both customers and administrators.{" "}
        </p>
        <div className="signed-in">
          <SignedOut>
            <div className="buttons">
              <SignInButton mode="modal">
                <button type="button">Sign in</button>
              </SignInButton>
              <SignUpButton mode="modal">
                <button type="button">Sign up</button>
              </SignUpButton>
            </div>
          </SignedOut>
          <SignedIn>
            <AuthRedirect />
          </SignedIn>
        </div>
      </div>
    </div>
  );
}

export default App;
