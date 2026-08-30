export function getPriority(id)
{
    if (id == 1) {
        return {"text" : "Low", "color" : "primary"};
    }
    if (id == 2) {
        return {"text" : "Medium", "color" : "warning"};
    }
    if (id == 3) {
        return {"text" : "High", "color" : "danger"};
    }
}