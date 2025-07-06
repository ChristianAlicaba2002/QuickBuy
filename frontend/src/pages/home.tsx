import NavbarComponent from "../components/navbar";
import CategoryComponent from "../components/category";
import "../../public/css/home.css";
import Get from "../hooks/get";
import type { TProducts } from "../types";
import CardComponent from "../components/card";

const API_URL = "http://127.0.0.1:8000/api/products";

export default function Home() {

  const { data, isLoading, error } = Get(API_URL);
  if (isLoading) {
    return (
      <div className="loader-container">
        <div className="loader"></div>
      </div>
    );
  }
  if (error) return console.log(error);

  const uniqueCategories = Array.from(
    new Set(data.map((item: TProducts) => item.category))
  );

  return (
    <div className="home-container">
      <NavbarComponent />
      <nav className="category-container">
        {uniqueCategories.map((item, index) => {
          return <CategoryComponent
                  key={index}
                  category={item} 
                  />;
        })}
      </nav>
      <main>
        <div className="card-container">
          {[...data]
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
