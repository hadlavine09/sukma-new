<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class DetailToko extends Model
{
     use HasFactory,SoftDeletes;

    protected $table = 'detail_tokos';
    protected $primaryKey = 'id';


    protected $guarded = ['id'];
}

// <!DOCTYPE html>
// <html lang="id">
// <head>
//   <meta charset="UTF-8" />
//   <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
//   <title>Rute 3D Dinamis</title>
//   <link rel="stylesheet" href="https://js.arcgis.com/4.31/esri/themes/light/main.css"/>
//   <script src="https://js.arcgis.com/4.31/"></script>
//   <style>
//     html, body, #viewDiv {
//       margin: 0; padding: 0;
//       height: 100%; width: 100%;
//     }
//     #clearButton {
//       position: absolute;
//       top: 10px;
//       left: 10px;
//       z-index: 99;
//       padding: 8px 12px;
//     }
//   </style>
// </head>
// <body>
//   <div id="viewDiv"></div>
//   <button id="clearButton">Clear Route</button>

//   <script>
//   require([
//     "esri/Map", "esri/views/SceneView", "esri/Graphic", "esri/layers/GraphicsLayer",
//     "esri/geometry/Point", "esri/geometry/Polyline", "esri/layers/ElevationLayer",
//     "esri/symbols/SimpleLineSymbol", "esri/symbols/SimpleMarkerSymbol",
//     "esri/geometry/geometryEngine", "esri/geometry/projection"
//   ], function (
//     Map, SceneView, Graphic, GraphicsLayer, Point, Polyline, ElevationLayer,
//     SimpleLineSymbol, SimpleMarkerSymbol, geometryEngine, projection
//   ) {

//     const map = new Map({
//       basemap: "topo-vector",
//       ground: "world-elevation"
//     });

//     // Layer khusus route line (garis rute hijau)
//     const RouteKemiringanLayer = new GraphicsLayer();
//     map.add(RouteKemiringanLayer);

//     const view = new SceneView({
//       container: "viewDiv",
//       map: map,
//       center: [107.6098, -6.9147],
//       zoom: 12,
//       pitch: 60
//     });

//     const elevationLayer = new ElevationLayer({
//       url: "https://elevation3d.arcgis.com/arcgis/rest/services/WorldElevation3D/Terrain3D/ImageServer"
//     });

//                 let cancelRoute = false;

//                 async function findRouteKemiringanPergerakanFromPointToALL(startLongitude, startLatitude, endLongitude, endLatitude) {
//                     const RADIUS = 100;
//                     const DEG_TO_RAD = Math.PI / 180;
//                     cancelRoute = false;

//                     // Tambahkan Layer ke peta jika belum
//                     if (!map.layers.includes(RouteKemiringanLayer)) {
//                         map.add(RouteKemiringanLayer);
//                     }

//                     RouteKemiringanLayer.removeAll();

//                     const tujuanPoint = new Point({ longitude: endLongitude, latitude: endLatitude });

//                     function safeAddRouteLine(graphic) {
//                         if (!cancelRoute) RouteKemiringanLayer.add(graphic);
//                     }

//                     function calculateBearing(p1, p2) {
//                         const lon1 = p1.longitude * DEG_TO_RAD;
//                         const lat1 = p1.latitude * DEG_TO_RAD;
//                         const lon2 = p2.longitude * DEG_TO_RAD;
//                         const lat2 = p2.latitude * DEG_TO_RAD;
//                         const dLon = lon2 - lon1;
//                         const y = Math.sin(dLon) * Math.cos(lat2);
//                         const x = Math.cos(lat1) * Math.sin(lat2) - Math.sin(lat1) * Math.cos(lat2) * Math.cos(dLon);
//                         return (Math.atan2(y, x) * 180 / Math.PI + 360) % 360;
//                     }

//                     async function getElevation(point) {
//                         try {
//                             const result = await elevationLayer.queryElevation(point);
//                             return result.geometry.z;
//                         } catch (e) {
//                             console.error("Gagal ambil elevasi:", e);
//                             return null;
//                         }
//                     }

//                     async function calculateDistanceInMeters(p1, p2) {
//                         const projectedP1 = await projection.project(p1, { wkid: 3857 });
//                         const projectedP2 = await projection.project(p2, { wkid: 3857 });
//                         return geometryEngine.distance(projectedP1, projectedP2, "meters");
//                     }

//                     async function findBestNextPoint(centerPoint, elevation, tolerance) {
//                         if (cancelRoute) return null;

//                         const bearingToDestination = calculateBearing(centerPoint, tujuanPoint);
//                         const points = [];

//                         for (let angle = 0; angle <= 360; angle += 10) {
//                             const rad = (bearingToDestination + angle) * DEG_TO_RAD;
//                             const lon = centerPoint.longitude + (RADIUS * Math.cos(rad)) / 111320;
//                             const lat = centerPoint.latitude + (RADIUS * Math.sin(rad)) / 110574;
//                             points.push(new Point({ longitude: lon, latitude: lat }));
//                         }

//                         const results = await Promise.all(points.map(p =>
//                             elevationLayer.queryElevation(p).catch(() => null)
//                         ));

//                         const candidates = [];

//                         results.forEach((result, idx) => {
//                             if (result?.geometry?.z != null) {
//                                 const z = result.geometry.z;
//                                 if (z >= elevation - tolerance && z <= elevation + tolerance) {
//                                     candidates.push({ geometry: result.geometry, elevation: z });
//                                 }
//                             }
//                         });

//                         if (candidates.length === 0) return null;

//                         candidates.sort((a, b) => {
//                             const bearingA = calculateBearing(centerPoint, a.geometry);
//                             const bearingB = calculateBearing(centerPoint, b.geometry);
//                             const diffA = Math.abs(bearingA - bearingToDestination);
//                             const diffB = Math.abs(bearingB - bearingToDestination);
//                             return diffA - diffB;
//                         });

//                         return candidates[0];
//                     }

//                     const verticalTolerance = RADIUS * 0.15;
//                     let currentPoint = new Point({ longitude: startLongitude, latitude: startLatitude });
//                     let currentElevation = await getElevation(currentPoint);

//                     if (currentElevation == null) {
//                         console.warn("Gagal mendapatkan elevasi titik awal");
//                         return;
//                     }

//                     while (!cancelRoute) {
//                         const distanceToGoal = await calculateDistanceInMeters(currentPoint, tujuanPoint);
//                         if (distanceToGoal < RADIUS) {
//                             console.log("Tujuan tercapai!");
//                             break;
//                         }

//                         const nextPointData = await findBestNextPoint(currentPoint, currentElevation, verticalTolerance);
//                         if (!nextPointData) {
//                             console.warn("Tidak ada titik berikutnya yang sesuai.");
//                             break;
//                         }

//                         const routeLine = new Graphic({
//                             geometry: new Polyline({
//                                 paths: [[[currentPoint.longitude, currentPoint.latitude], [nextPointData.geometry.longitude, nextPointData.geometry.latitude]]],
//                                 spatialReference: { wkid: 4326 } // Penting: pastikan ada spatialReference
//                             }),
//                             symbol: {
//                                 type: "simple-line",
//                                 color: 'yellow',
//                                 width: 3
//                             }
//                         });

//                         safeAddRouteLine(routeLine);

//                         currentPoint = nextPointData.geometry;
//                         currentElevation = nextPointData.elevation;
//                     }
//                 }


//             //
//             //  Mulai route pertama saat view siap
//               findRouteKemiringanPergerakanFromPointToALL(
//                 107.5810434201771,
//                 -6.999260814553066,
//                 107.59886191600248,
//                 -6.896812834291304
//               );

//             // Clear route button: hanya hapus garis rute saja, marker tetap ada
//             document.getElementById("clearButton").addEventListener("click", () => {
//               cancelRoute = true;
//               RouteKemiringanLayer.removeAll();
//               // Marker tetap ada karena di layer terpisah
//             });

//   });
//   </script>
// </body>
// </html>
