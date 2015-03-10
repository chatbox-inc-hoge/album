
class Animal
  constructor: (@config) ->
  upload:
    zip: (category,file)->
      console.log "hogehoge"
  move: (meters) ->
    alert @name + " moved " + meters + "m."


sam = new Snake "Sammy the Python"
tom = new Horse "Tommy the Palomino"

sam.move()
tom.move()



module.exports = Album