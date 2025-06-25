document.getElementById('tactical_point').addEventListener('click', toggleTacticalPoints);

                    view.on("click", function (event) {
                        view.hitTest(event).then(function (response) {
                            const result = response.results.find(res => res.graphic?.layer === tacticalPointLayer);

                            if (result && result.graphic && result.graphic.attributes) {
                                const clickedGraphicTactical = result.graphic;
                                toggleBuffer(clickedGraphicTactical); // Menampilkan/menghilangkan buffer
                            } else {
                                removeAllBuffers();
                                hideTextData();
                            }
                        });
                    });

                    function toggleBuffer(graphic) {
                        // Pastikan graphic dan attributes tidak null sebelum lanjut
                        if (!graphic || !graphic.attributes) {
                            console.error("Graphic atau attributes tidak valid:", graphic);
                            return;
                        }

                        const existingBuffers = tacticalPointLayer.graphics.items.filter(g =>
                            g.attributes?.id_drawing === graphic.attributes.id_drawing && g.attributes?.isBuffer
                        );

                        if (existingBuffers.length > 0) {
                            removeAllBuffers();
                            hideTextData();
                        } else {
                            let iconUrl = graphic.attributes.icon === 'destroyed-alt' ?
                                "assets/iconMap/gun_detected/destroyed_alt.png" :
                                `assets/iconMap/${graphic.attributes.type_icon}/${graphic.attributes.icon}.png`;

                            const point_latlon = new Point({
                                longitude: graphic.attributes.longitude,
                                latitude: graphic.attributes.latitude,
                                spatialReference: new SpatialReference({ wkid: 4326 })
                            });

                            const markerSymbol = {
                                type: "picture-marker",
                                url: iconUrl,
                                width: "24px",
                                height: "24px"
                            };

                            const pointGraphic = new Graphic({
                                geometry: point_latlon,
                                symbol: markerSymbol,
                            });

                            try {
                                const buffer = geometryEngine.geodesicBuffer(point_latlon, 500, "meters");

                                const bufferGraphic = new Graphic({
                                    geometry: buffer,
                                    symbol: {
                                        type: "simple-fill",
                                        color: [0, 255, 255, 0.2],
                                        outline: {
                                            color: "cyan",
                                            width: 1
                                        }
                                    },
                                    attributes: {
                                        id_drawing: graphic.attributes.id_drawing,
                                        isBuffer: true
                                    }
                                });

                                tacticalPointLayer.addMany([bufferGraphic, pointGraphic]);
                                updateTextData(
                                    graphic.attributes.longitude,
                                    graphic.attributes.latitude,
                                    null,
                                    graphic.attributes.title,
                                    graphic.attributes.description,
                                    graphic.attributes.category,
                                    graphic.attributes.insert_date
                                );
                            } catch (error) {
                                console.error("Error saat membuat buffer:", error);
                            }
                        }
                    }

                    function removeAllBuffers() {
                        const buffers = tacticalPointLayer.graphics.items.filter(g => g.attributes?.isBuffer);
                        buffers.forEach(buffer => tacticalPointLayer.remove(buffer));
                        console.log("Semua buffer dihapus");
                    }

                    function updateTacticalPoints(newData) {
                        let newIds = newData.map(point => point.id_drawing);

                        tacticalPointLayer.graphics.items.slice().forEach(graphic => {
                            if (graphic.attributes && !newIds.includes(graphic.attributes.id_drawing)) {
                                tacticalPointLayer.remove(graphic);
                            }
                        });

                        newData.forEach(point => {
                            try {
                                let jsonData = typeof point.json_data === "string" ? JSON.parse(point.json_data) : point.json_data;
                                if (point.type === "point" && typeof jsonData.x === "number" && typeof jsonData.y === "number") {
                                    let iconUrl = point.icon === 'destroyed-alt' ?
                                        "assets/iconMap/gun_detected/destroyed_alt.png" :
                                        `assets/iconMap/${point.type_icon}/${point.icon}.png`;

                                    const point_latlon = new Point({
                                        longitude: jsonData.x,
                                        latitude: jsonData.y,
                                        spatialReference: { wkid: 4326 }
                                    });

                                    const markerSymbol = new Graphic({
                                        geometry: point_latlon,
                                        symbol: {
                                            type: "picture-marker",
                                            url: iconUrl,
                                            width: "24px",
                                            height: "24px"
                                        },

                                        attributes: {
                                            id_drawing: point.id_drawing || null,
                                            title: point.title || "Unknown",
                                            description: point.description || "No description",
                                            latitude: jsonData.y,
                                            longitude: jsonData.x,
                                            insert_date: point.insert_date || "Unknown",
                                            category: point.name_category || "Unknown",
                                            icon: point.icon || "default",
                                            type_icon: point.type_icon || "default"
                                        }
                                    });

                                    tacticalPointLayer.add(markerSymbol);
                                }
                            } catch (error) {
                                console.error("Error parsing JSON data:", error, point);
                            }
                        });
                    }

                    function toggleTacticalPoints() {
                        if (pointsAdded.tactical) {
                            tacticalPointLayer.removeAll();
                            pointsAdded.tactical = false;
                        } else if (tacticalData.length > 0) {
                            updateTacticalPoints(tacticalData);
                            pointsAdded.tactical = true;
                        } else {
                            tacticalPointLayer.removeAll();
                        }
                    }
