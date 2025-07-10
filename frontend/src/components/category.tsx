import "../../public/css/category.css"

type TCategory = {
    category:string
}

export default function CategoryComponent(props:TCategory) {

    const searchItem = async (e: React.FormEvent) => {
      e.preventDefault();
          
    }
  
  return (
    <nav>
        <button className="category-button" onSubmit={searchItem} type="button">
            {props.category}
        </button>
    </nav>
  )
}
