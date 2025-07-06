import type { TProducts } from "../types";
import ButtonComponent from "./button";
import "../../public/css/card.css";
import React, { useEffect, useState } from "react";
import { useUser } from "@clerk/clerk-react";
// import type { TAddToCart } from "../types";

export default function CardComponent(props: TProducts) {
  const [userId, setUserId] = useState<string>("");
  // const [CartItem, setCartItem] = useState<TAddToCart>({
  //   user_id: "",
  //   product_id: 0,
  //   name: "",
  //   category: "",
  //   price: 0,
  //   stock: 0,
  //   quantity: 0,
  //   description: "",
  //   image: "",
  // })

  //Get the User ID
  const { user } = useUser();
  useEffect(() => {
    if (user) {
      setUserId(user.emailAddresses[0].id);
    }
  }, [user]);

  //Add item in the user cart
  const addToCart = async (e: React.FormEvent) => {
    e.preventDefault();


    //Set the specific item details
    // setCartItem((prev) => ({
    //   ...prev,
    //   user_id: userId,
    //   product_id: props.product_id,
    //   name: props.name,
    //   category: props.category,
    //   price: props.price,
    //   stock: props.stock,
    //   quantity: quantity += 1,
    //   description: props.description,
    //   image: props.image,
    // })

    // );

    try {
      const response = await fetch(`http://127.0.0.1:8000/api/addToCart/${props.product_id}`, {
        method: "POST",
        headers: {
          Authorization: `Bearer ${userId}`,
          "Content-Type": "application/json",
        },
        body: JSON.stringify({
          user_id: userId,
          product_id: props.product_id,
          name: props.name,
          category: props.category,
          price: props.price,
          stock: props.stock,
          quantity: 1,
          description: props.description,
          image: props.image,
        }),
      });

      //Check if the response is not OK!
      if (!response.ok) {
        console.error("Error:", response.status);
        return;
      }

      //Get the response DATA
      const data = await response.json();
      console.log("Added to cart:", data.message);
      window.location.reload()

    } catch (error) {
      console.error("Fetch error:", error);
    }
  };

  //Product image url
  const imageUrl = `http://127.0.0.1:8000/api/storage/${props.image}`;

  return (
    <div className="main-Container">
      <div className="image-container">
        <img src={imageUrl} alt={props.name} width={40} height={40} />
      </div>
      <div className="details-container">
        <div className="info">
          <h1>{props.name}</h1>
          <h2>{props.category}</h2>
          <h3>&#8369; {props.price}</h3>
        </div>
        <div className="button-container">
          <form onSubmit={addToCart}>
            <ButtonComponent name="Add to cart" />
          </form>
        </div>
      </div>
    </div>
  );
}
