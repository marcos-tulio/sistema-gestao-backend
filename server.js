const cors = require("cors")
const jsonServer = require("json-server")
const server = jsonServer.create()
const router = jsonServer.router("db.json")
const middlewares = jsonServer.defaults()
const fs = require("fs")

server.use(cors()) // ou configure com opções: cors({ origin: 'http://localhost:5173' })

server.use(middlewares)

// Retorna um item específico
server.get("/financial/types/:id", (req, res) => {
    const db = JSON.parse(fs.readFileSync("db.json"))
    const id = parseInt(req.params.id)
    const type = db.financial?.types?.find(i => i.id === id)
    if (type) res.json(type)
    else res.status(404).json({ error: "Not found" })
})

// Nova rota: retorna os itens internos de um item
server.get("/financial/types/:id/categories", (req, res) => {
    const db = JSON.parse(fs.readFileSync("db.json"))
    const id = parseInt(req.params.id)
    const type = db.financial?.types?.find(i => i.id === id)

    if (type && Array.isArray(type.categories)) {
        res.json(type.categories)
    } else if (type) {
        res.json([]) // existe mas não tem sub-itens
    } else {
        res.status(404).json({ error: "Item not found" })
    }
})

server.use(router)
server.listen(3003, () => {
    console.log("JSON Server is running")
})


