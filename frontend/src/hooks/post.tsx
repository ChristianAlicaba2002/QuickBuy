import { useEffect } from "react"

export default function Post(api: string , userData:any) {
  
    useEffect(()=> {
        const postData = async () => {
            const response = await fetch(api , {
                method: "POST",
                headers: {
                    "Content-Type": "application/json"
                },
                body: JSON.stringify(userData)
            });
            
            const data = await response.json()
            if(data) console.log(data);
        }
        postData()
    },[api , userData])  
}
