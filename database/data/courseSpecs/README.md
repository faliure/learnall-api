# Spec Format

Files in this folder are used as specs to create Course structures. The structure is as follows:

```
type ExerciseDefinition {
    // Variable structure, depends on the Exercise's ExerciseType
}

type ExerciseSpec {
    type: String    // ExerciseType.name
    description: String
    definition: ExerciseDefinition
    enabled: ?Boolean // Default: TRUE
}

type LessonSpec {
    name: String
    description: ?String
    enabled: ?Boolean // Default: ! empty(exercises)
    exercises: ?ExerciseSpec[]
}

type UnitSpec {
    name: String
    description: ?String
    enabled: ?Boolean // Default: ! empty(lessons)
    lessons: ?LessonSpec[]
}

type LevelSpec {
    name: String
    description: ?String
    enabled: ?Boolean // Default: ! empty(units)
    units: ?UnitSpec[]
}

type CourseSpec LevelSpec[]
```

- The root structure is a `CourseSpec`, i.e. an array of LevelSpec's.
- Nullable fields can be omitted

Example:

```json
[
    {
        "name": "Level 1",
        "description": "This is Level number 1",
        "units": [
            {
                "name": "Unit 1",
                "description": "This is Unit number 1",
                "lessons": [
                    {
                        "name": "Lesson 1",
                        "description": "This is Lesson number 1",
                        "exercises": [
                            {
                                "type": "ReadAndTranslate",
                                "description": "Exercise 1-1",
                                "definition": {
                                    "learnable": 123
                                },
                            },
                            {
                                "type": "ReadAndSpeak",
                                "description": "Exercise 1-2",
                                "definition": {
                                    "learnable": 124
                                },
                            }
                        ]
                    },
                    {
                        "name": "Lesson 2",
                        "enabled": true
                        // No description
                        // No exercises yet
                    },
                    {
                        "name": "Lesson 3",
                        // Enabled = false (it has no exercises, so it defaults to false)
                        // No description
                        // No exercises yet
                    }
                ]
            },
            {
                "name": "Unit 2"
                // No description
                // No Lessons yet
            }
        ]
    },
    {
        "name": "Level 2"
        // No description
        // No Units yet
    }
]
```
