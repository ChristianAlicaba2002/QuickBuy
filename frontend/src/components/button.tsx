type TButton = {
    name:string
    stock:number
}
export default function ButtonComponent(props:TButton) {
  return (
    <div>
      {props.stock <= 0 ? (
        <button className="card-button" type="submit" disabled style={{cursor: "not-allowed" }}>
          {props.name}
        </button>
      ) : (
        <button className="card-button" type="submit">
          {props.stock <= 0 ? "Out of stock" : props.name}
        </button>
      )}
    </div>
  )
}
