export function getStatus(status){
    let arr = {
        1 : {text: "Pending", color: "secondary"},
        2 : {text: "Development", color: "primary"},
        3 : {text: "Testing", color: "warning"},
        4: {text: "Staging", color: "info"},
        5: {text: "Deployed", color: "success"},
        6: {text: "Published", color: "purple"}
    }
    return arr[status];
}