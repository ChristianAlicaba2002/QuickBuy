import { useUser, SignedIn, UserButton, SignedOut } from "@clerk/clerk-react";
import { useEffect, useState } from "react";
import { useNavigate } from "react-router-dom";
import type { TUser, TCartItem } from "../types";
import "../../public/css/navbar.css";
import { BsCartCheck } from "react-icons/bs";
import { FaArrowLeft } from "react-icons/fa";
import Logo from "../../public/images/shop.png";

function AuthRedirect() {
  const navigate = useNavigate();
  useEffect(() => {
    navigate("/");
  }, [navigate]);
  return null;
}

type Props = {
  search: string;
  setSearch: (value: string) => void;
};

export default function NavbarComponent({ setSearch }: Props) {
  const { user, isSignedIn } = useUser();

  const [isCartOpen, setIsCartOpen] = useState(false);
  const [cartItem, setCartItem] = useState<TCartItem[]>([]);

  const [isLoading, setIsLoading] = useState(true);
  const [itemTotal, setItemTotal] = useState(0);
  const [checkedItems, setCheckedItems] = useState<{ [productId: string]: boolean }>({});
  const [quantity, setQuantity] = useState<{ [productId: string]: number }>({});
  const [total, setTotal] = useState(0);
  // const [isSearching, setIsSearching] = useState(false);
  const [userAuth, setUserAuth] = useState<TUser>({
    user_id: "",
    first_name: "",
    last_name: "",
    email: "",
  });

  // Set user auth data
  useEffect(() => {
    if (!isSignedIn || !user) return;
    setUserAuth({
      user_id: user.emailAddresses[0]?.id || "",
      first_name: user.firstName || "",
      last_name: user.lastName || "",
      email: user.emailAddresses[0]?.emailAddress || "",
    });
  }, [isSignedIn, user]);

  // Send user to Laravel
  useEffect(() => {
    const postUser = async () => {
      await fetch("http://127.0.0.1:8000/api/users", {
        method: "POST",
        headers: {
          Authorization: `Bearer ${userAuth.user_id}`,
          "Content-Type": "application/json",
        },
        body: JSON.stringify(userAuth),
      });
    };
    if (userAuth.user_id) postUser();
  }, [userAuth]);

  // Get user's cart
  useEffect(() => {
    const userItemCart = async () => {
      try {
        const response = await fetch(
          `http://127.0.0.1:8000/api/userItemCart/${userAuth.user_id}`
        );
        if (!response.ok) return;

        const item = await response.json();
        setCartItem(item.data);
        setItemTotal(item.count);
        localStorage.setItem("itemCart", JSON.stringify(item.data));
      } catch (error) {
        console.log(error);
      }
    };
    if (userAuth.user_id) {
      userItemCart();
    }
  }, [userAuth.user_id]);


  const searchItem = (e: React.ChangeEvent<HTMLInputElement>) => {
    setSearch(e.target.value);
  };

  // const handleSearch = async () => {
  //   setIsSearching(true);
  //   await new Promise((resolve) => setTimeout(resolve, 500));

  //   setIsSearching(false);
  // };
  const checkOutItem = async (e: React.FormEvent) => {
    e.preventDefault();

    // Filter checked items and include quantity
    const checkedCartItems = cartItem
      .filter((item) => checkedItems[item.product_id])
      .map((item) => ({
        ...item,
        quantity: quantity[item.product_id] ?? item.quantity,
      }));

    if (checkedCartItems.length === 0) {
      alert("Please select items to checkout.");
      return;
    }
    const checkOutItemObject = {
      user_id: userAuth.user_id,
      checkedCartItems
    }

    try {
      const response = await fetch("http://localhost:8000/api/userOrder", {
        method: "POST",
        headers: {
          Authorization: `Bearer ${userAuth.user_id}`,
          "Content-Type": "application/json",
        },
        body: JSON.stringify({
          checkOutItemObject
        }),
      });

      if (!response.ok) {
        console.error("Checkout failed.");
        return;
      }

      const data = await response.json();
      console.log("Checkout successful:", data.data);

      // Optionally clear checked items and reset state
      setCheckedItems({});
      setTotal(0);
      setIsCartOpen(false);

      // You may also want to refresh the cart
    } catch (error) {
      console.error("Checkout error:", error);
    }
  };
  useEffect(() => {
    setIsLoading(true);
    const timer = setTimeout(() => setIsLoading(false), 2000);
    return () => clearTimeout(timer);
  }, []);

  const handleCheckItem = (item: TCartItem) => {
    const currentQty = quantity[item.product_id] ?? item.quantity;
    const isChecked = !checkedItems[item.product_id];

    setCheckedItems((prev) => ({
      ...prev,
      [item.product_id]: isChecked,
    }));

    setQuantity((q) => ({
      ...q,
      [item.product_id]: currentQty,
    }));

    setTotal((prevTotal) =>
      isChecked
        ? prevTotal + currentQty * item.price
        : prevTotal - currentQty * item.price
    );
  };

  const plusQuantity = (item: TCartItem) => {
    setQuantity((q) => {
      const currentQty = q[item.product_id] ?? item.quantity;
      const newQty = Math.min(item.stock, currentQty + 1);

      if (checkedItems[item.product_id]) {
        setTotal((prevTotal) => prevTotal * item.price);
      }

      return {
        ...q,
        [item.product_id]: newQty,
      };
    });
  };

  const minusQuantity = (item: TCartItem) => {
    setQuantity((q) => {
      const currentQty = q[item.product_id] ?? item.quantity;
      const newQty = Math.max(1, currentQty - 1);

      if (checkedItems[item.product_id] && currentQty > 1) {
        setTotal((prevTotal) => prevTotal - Number(item.price));
      }

      return {
        ...q,
        [item.product_id]: newQty,
      };
    });
  };

  const checkAllItem = () => {
    const allChecked = cartItem.every((item) => checkedItems[item.product_id]);

    const updatedCheckedItems: { [productId: string]: boolean } = {};
    const updatedQuantities: { [productId: string]: number } = {};
    let newTotal = 0;

    cartItem.forEach((item) => {
      const qty = quantity[item.product_id] ?? item.quantity;

      updatedQuantities[item.product_id] = qty;
      updatedCheckedItems[item.product_id] = !allChecked;

      if (!allChecked) {
        newTotal += qty * item.price;
      }
    });

    setCheckedItems(updatedCheckedItems);
    setQuantity((prev) => ({ ...prev, ...updatedQuantities }));
    setTotal(newTotal);
  };

  return (
    <nav>
      {isSignedIn ? (
        <>
          <div className="nav-container">
            <div className="logo-img">
              <img src={Logo} alt="Logo" />
            </div>
            <div className="search-container">
              <input
                title="search your product"
                type="search"
                placeholder="Search products..."
                onChange={searchItem}
              />
              {/* <button type="submit" onClick={handleSearch} disabled={isSearching}>
                {isSearching ? "Searching..." : "Search"}
              </button> */}
            </div>
            <div className="right-side">
              <div className="cart-container">
                <div className="number-cart">
                  <label>{itemTotal}</label>
                </div>
                <BsCartCheck
                  onClick={() => setIsCartOpen((prev) => !prev)}
                  title="Check your items"
                />
              </div>
              <div className="signedIn-btn">
                <SignedIn>
                  <UserButton
                    appearance={{
                      elements: {
                        userButtonAvatarBox: {
                          width: "35px",
                          height: "35px",
                        },
                      },
                    }}
                  />
                </SignedIn>
              </div>
            </div>
          </div>

          {isCartOpen && (
            <div className="addToCart-container">
              <div className="header-container">
                <FaArrowLeft
                  onClick={() => setIsCartOpen(false)}
                  className="arrow-icon"
                />
                <h1>Shopping Cart</h1>
              </div>

              {isLoading ? (
                <div className="loader-cart-container">
                  <div className="loader-cart"></div>
                </div>
              ) : (
                <div className="product-container">
                  {cartItem.length > 0 ? (
                    cartItem.map((item: TCartItem) => {
                      const imageUrl = `http://127.0.0.1:8000/api/storage/${item.image}`;
                      return (
                        <div key={item.product_id} className="item-container">
                          <input
                            type="checkbox"
                            checked={!!checkedItems[item.product_id]}
                            onChange={() => handleCheckItem(item)}
                          />
                          <img src={imageUrl} width={75} height={70} />
                          <div>
                            <h3>{item.name}</h3>
                            <p>Stock: {item.stock}</p>
                            <p>Qty: {quantity[item.product_id] ?? item.quantity}</p>
                            <h4>&#8369;{item.price.toLocaleString("en-PH")}</h4>
                          </div>
                          <div className="quantity-container">
                            <button
                              type="button"
                              className="quantity-button"
                              disabled={
                                !checkedItems[item.product_id] ||
                                (quantity[item.product_id] ?? item.quantity) <= 1
                              }
                              onClick={() => minusQuantity(item)}
                            >
                              -
                            </button>
                            <input
                              type="text"
                              value={quantity[item.product_id] ?? item.quantity}
                              readOnly
                            />
                            <button
                              type="button"
                              className="quantity-button"
                              disabled={
                                !checkedItems[item.product_id] ||
                                (quantity[item.product_id] ?? item.quantity) >= item.stock
                              }
                              onClick={() => plusQuantity(item)}
                            >
                              +
                            </button>
                          </div>
                        </div>
                      );
                    })
                  ) : (
                    <h1 className="no-item-message">No item in your cart</h1>
                  )}
                </div>
              )}
              <footer className="bottom-container">
                <div className="check-all-container">
                  <label htmlFor="check-all">
                    <input
                      type="checkbox"
                      id="check-all"
                      onClick={checkAllItem}
                      checked={cartItem.length > 0 && cartItem.every(item => checkedItems[item.product_id])}
                      readOnly
                    />
                    Check All
                  </label>
                </div>
                <div className="processing-container">
                  <div className="subtotal-container">
                    <p>Total: &#8369; {total.toLocaleString("en-PH")}</p>
                  </div>
                  <div className="checkout-container">
                    <form onSubmit={checkOutItem} method="POST" encType="multipart/form-data">
                      <button type="submit">Check out</button>
                    </form>
                  </div>
                </div>
              </footer>
            </div>
          )}
        </>
      ) : (
        <SignedOut>
          <AuthRedirect />
        </SignedOut>
      )}
    </nav>
  );
}
