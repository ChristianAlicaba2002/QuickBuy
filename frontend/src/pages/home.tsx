import { useState } from "react";
import NavbarComponent from "../components/navbar";
import CategoryComponent from "../components/category";
import "../../public/css/home.css";
import Get from "../hooks/get";
import type { TProducts } from "../types";
import CardComponent from "../components/card";

const API_URL = "http://127.0.0.1:8000/api/products";

export default function Home() {
  const { data, isLoading, error } = Get(API_URL);
  const [search, setSearch] = useState<string>("");

  if (isLoading) {
    return (
      <div className="loader-container">
        <div className="loader"></div>
      </div>
    );
  }

  if (error) {
    console.error(error);
    return <div>Error loading products.</div>;
  }

  const uniqueCategories = Array.from(
    new Set(data.map((item: TProducts) => item.category))
  );

  // Filter the products based on search input
  const filteredProducts = data.filter((item: TProducts) =>
    item.name.toLowerCase().includes(search.toLowerCase())
  );

  return (
    <div className="home-container">
      <NavbarComponent search={search} setSearch={setSearch} />

      <nav className="category-container">
        {uniqueCategories.map((item, index) => (
          <CategoryComponent key={index} category={item} />
        ))}
      </nav>

      <main>
        <div className="card-container">
          {filteredProducts
            .sort((a: TProducts, b: TProducts) => b.name.localeCompare(a.name))
            .map((item: TProducts) => (
              <CardComponent
                key={item.product_id}
                product_id={item.product_id}
                image={item.image}
                name={item.name}
                category={item.category}
                price={item.price}
                stock={item.stock}
                description={item.description}
              />
            ))}
        </div>
      </main>
    </div>
  );
}
