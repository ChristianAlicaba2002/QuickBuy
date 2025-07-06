type TButton = {
    name:string
}
export default function ButtonComponent(props:TButton) {
  return (
    <div>
        <button className="card-button" type="submit">{props.name}</button>
    </div>
  )
}
