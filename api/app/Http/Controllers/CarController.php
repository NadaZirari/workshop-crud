<?php

namespace App\Http\Controllers;
use App\Models\Car;
use Illuminate\Http\Request;

class CarController extends Controller
{
     /**
     * @OA\Get(
     *     path="/api/cars",
     *     summary="Lister toutes les voitures",
     *     tags={"Cars"},
     *     @OA\Response(response=200, description="Liste des voitures")
     * )
     */
    
    public function index()
    {
        return response()->json(Car::all(), 200);
    }

    /**
     * @OA\Post(
     *     path="/api/cars",
     *     summary="Créer une voiture",
     *     tags={"Cars"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"brand", "model", "year", "price_per_day"},
     *             @OA\Property(property="brand", type="string"),
     *             @OA\Property(property="model", type="string"),
     *             @OA\Property(property="year", type="integer"),
     *             @OA\Property(property="price_per_day", type="number", format="float")
     *         )
     *     ),
     *     @OA\Response(response=201, description="Voiture créée")
     * )
     */
    public function store(Request $request)
    {
        $request->validate([
            'brand' => 'required|string',
            'model' => 'required|string',
            'year' => 'required|integer',
            'price_per_day' => 'required|numeric'
        ]);

        $car = Car::create($request->all());

        return response()->json($car, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $car = Car::find($id);
        return $car ? response()->json($car, 200) : response()->json(['message' => 'Voiture non trouvée'], 404);
    }

     /**
     * @OA\Put(
     *     path="/api/cars/{id}",
     *     summary="Mettre à jour une voiture",
     *     tags={"Cars"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID de la voiture",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"brand", "model", "year", "price_per_day"},
     *             @OA\Property(property="brand", type="string"),
     *             @OA\Property(property="model", type="string"),
     *             @OA\Property(property="year", type="integer"),
     *             @OA\Property(property="price_per_day", type="number", format="float")
     *         )
     *     ),
     *     @OA\Response(response=200, description="Voiture mise à jour"),
     *     @OA\Response(response=404, description="Voiture non trouvée")
     * )
     */
    public function update(Request $request, $id)
    {
        $car = Car::find($id);
        if (!$car) {
            return response()->json(['message' => 'Voiture non trouvée'], 404);
        }

        $car->update($request->all());
        return response()->json($car, 200);
    }


   
    /**
     * @OA\Delete(
     *     path="/api/cars/{id}",
     *     summary="Supprimer une voiture",
     *     tags={"Cars"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID de la voiture",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(response=204, description="Voiture supprimée"),
     *     @OA\Response(response=404, description="Voiture non trouvée")
     * )
     */
    public function destroy($id)
    {
        $car = Car::find($id);
        if (!$car) {
            return response()->json(['message' => 'Voiture non trouvée'], 404);
        }

        $car->delete();
        return response()->json(null, 204);
    }
}
